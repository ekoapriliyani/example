<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKawatDuri;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiKawatDuriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiKawatDuri::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_kawat_duri.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSKD{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = InspeksiKawatDuri::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSKD202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_kawat_duri.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Ambil data tervalidasi ke dalam variabel
        $validated = $request->validate([
            'nomor_inspeksi' => 'required', // Lepas unique rule di sini karena nomor di-generate ulang di backend agar aman
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string',
            'mesin_id' => 'nullable|exists:mesins,id',
            'type_coating' => 'required|string',
            'warna' => 'nullable|string',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        // 2. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSKD{$tahunBulan}";

        $lastRecord = InspeksiKawatDuri::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // 3. Masukkan nomor yang sudah pasti aman dan sinkron ke array data
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;

        // 4. Pastikan data nullable terisi default null jika kosong
        $validated['mesin_id'] = $validated['mesin_id'] ?? null;
        $validated['warna'] = $validated['warna'] ?? null;
        $validated['total_prod'] = $validated['total_prod'] ?? null;

        // 5. Simpan menggunakan data yang sudah tervalidasi (Lebih aman dibanding $request->all())
        InspeksiKawatDuri::create($validated);

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', "Data inspeksi {$fixNomorInspeksi} berhasil disimpan.");
    }
    /**
     * Display the specified resource.
     */
    public function show(InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $inspeksiKawatDuri->load(['pro', 'mesin', 'inspeksiKawatDuriWip', 'inspeksiKawatDuriFg']);
        return view('inspeksi_kawat_duri.show', compact('inspeksiKawatDuri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inspeksiKawatDuri = InspeksiKawatDuri::findOrFail($id);
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('mesin_id')->get();

        return view('inspeksi_kawat_duri.edit', compact(
            'inspeksiKawatDuri',
            'pros',
            'mesins'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_kawat_duris,nomor_inspeksi,' . $inspeksiKawatDuri->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string',
            'mesin_id' => 'nullable|exists:mesins,id',
            'type_coating' => 'required|string',
            'warna' => 'nullable|string',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $inspeksiKawatDuri->update($request->all());

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $inspeksiKawatDuri->delete();

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', 'Data berhasil dihapus.');
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiKawatDuri::findOrFail($id);

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
