<?php

namespace App\Http\Controllers;

use App\Models\InspeksiPvc;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiPvcController extends Controller
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

        $data = InspeksiPvc::with(['pro', 'mesin'])
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

        return view('inspeksi_pvc.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSPVC{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = InspeksiPvc::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSPVC202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_pvc.create', compact('nextNomor', 'pros', 'mesins'));
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
            'd_kawat_inti' => 'required',
            'd_kawat_pvc' => 'required',
            'type_coating' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
        ]);

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSPVC{$tahunBulan}";

        $lastRecord = InspeksiPvc::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        InspeksiPvc::create($validated);

        return redirect()
            ->route('inspeksi_pvc.index')
            ->with('success', "Inspeksi {$fixNomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiPvc $inspeksi_pvc)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();

        return view('inspeksi_pvc.edit', compact('inspeksi_pvc', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses hapus.');
        }

        $data = InspeksiPvc::findOrFail($id);

        if ($data->isApproved()) {
            return back()->with('error', 'Data sudah di-approve, tidak bisa dihapus.');
        }

        $data->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
