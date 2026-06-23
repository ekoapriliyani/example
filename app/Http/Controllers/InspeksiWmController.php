<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductWm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menangkap semua request filter
        $search = $request->input('search');
        $status = $request->input('status'); // nilainya 'pending' atau 'approved' dari form
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = InspeksiWm::with(['pro', 'mesin'])
            // Filter Pencarian (Search)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_inspeksi', 'like', "%{$search}%")
                        ->orWhereHas('pro', function ($proQuery) use ($search) {
                            $proQuery->where('description', 'like', "%{$search}%");
                        });
                });
            })
            // Filter Status menggunakan kolom 'approval_status'
            ->when($status, function ($query, $status) {
                if ($status === 'approved') {
                    return $query->where('approval_status', 'APPROVED');
                } elseif ($status === 'pending') {
                    // Bisa menggunakan orWhereNull untuk berjaga-jaga jika ada data lama yang masih kosong
                    return $query->where(function ($q) {
                        $q->where('approval_status', 'PENDING')
                            ->orWhereNull('approval_status');
                    });
                }
            })
            // Filter Range Tanggal (Start Date)
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('tanggal', '>=', $startDate);
            })
            // Filter Range Tanggal (End Date)
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('tanggal', '<=', $endDate);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_wm.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSWM{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            // Ambil string nomor aslinya, buang prefix-nya
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        // 3. PERBAIKAN: Gunakan str_pad agar nomor urut konsisten memiliki panjang 3 digit (001, 002, dst)
        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSWM202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_wm.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
        ]);

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSWM{$tahunBulan}";

        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // 2. Masukkan nomor yang sudah pasti aman dan sinkron ke array data
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;
        $validated['mesin_id'] = $validated['mesin_id'] ?? null;
        $validated['total_prod'] = $validated['total_prod'] ?? null;

        // 3. Simpan ke database menggunakan data yang sudah tervalidasi
        InspeksiWm::create($validated);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', "Inspeksi {$fixNomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiWm $inspeksi_wm)
    {
        $inspeksi_wm->load(['pro', 'mesin', 'inspeksiWmWip', 'inspeksiWmFg']);
        return view('inspeksi_wm.show', ['inspeksi_wm' => $inspeksi_wm]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWm $inspeksi_wm)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();

        return view('inspeksi_wm.edit', compact('inspeksi_wm', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWm $inspeksi_wm)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'shear_strength' => 'nullable|numeric',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        $inspeksi_wm->update([
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'grade' => $validated['grade'],
            'type_coating' => $validated['type_coating'],
            'shear_strength' => $validated['shear_strength'] ?? null,
            'mesin_id' => $validated['mesin_id'] ?? null,
            'total_prod' => $validated['total_prod'] ?? null,
            'satuan' => $validated['satuan'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', 'Data inspeksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses hapus.');
        }

        $data = InspeksiWm::findOrFail($id);

        if ($data->isApproved()) {
            return back()->with('error', 'Data sudah di-approve, tidak bisa dihapus.');
        }

        $data->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Get PRO detail for AJAX.
     */
    public function getProDetail($id)
    {
        $pro = Pro::find($id);

        if (! $pro) {
            return response()->json([
                'message' => 'PRO tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'id' => $pro->id,
            'pro_id' => $pro->pro_id, // kode PRO dari Sybase
            'description' => $pro->description,
            'qty' => $pro->qty,
        ]);
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiWm::findOrFail($id);

        if ($inspeksi->isApproved()) {
            // UNAPPROVE
            $inspeksi->update([
                'approval_status' => 'PENDING',
                'approved_by' => null,
                'approved_at' => null,
            ]);

            $message = 'Approval dibatalkan.';
        } else {
            // APPROVE
            $inspeksi->update([
                'approval_status' => 'APPROVED',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $message = 'Data berhasil di-approve.';
        }

        return back()->with('success', $message);
    }
}
