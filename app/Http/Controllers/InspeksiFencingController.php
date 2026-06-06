<?php

namespace App\Http\Controllers;

use App\Models\InspeksiFencing;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiFencingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiFencing::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_fencing.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSFEN{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = InspeksiFencing::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSFEN202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_fencing.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required', // Lepas unique rule di sini karena nomor di-generate ulang di backend agar aman
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => '',
            'satuan' => 'required',
        ]);

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSFEN{$tahunBulan}";

        $lastRecord = InspeksiFencing::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $validated['total_prod'] = $validated['total_prod'] ?? null;

        // 3. Simpan ke database menggunakan data yang sudah tervalidasi
        InspeksiFencing::create($validated);

        return redirect()
            ->route('inspeksi_fencing.index')
            ->with('success', "Inspeksi {$fixNomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiFencing $inspeksi_fencing)
    {
        $inspeksi_fencing->load(['pro', 'mesin', 'inspeksiFencingWip', 'inspeksiFencingFg']);
        return view('inspeksi_fencing.show', ['inspeksi_fencing' => $inspeksi_fencing]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiFencing $inspeksiFencing)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();

        return view('inspeksi_fencing.edit', compact('inspeksiFencing', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => "required|unique:inspeksi_fencings,nomor_inspeksi,{$id}",
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',

            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => '',
            'satuan' => 'required',
        ]);

        $inspeksiFencing = InspeksiFencing::findOrFail($id);
        $inspeksiFencing->update($validated);

        return redirect()
            ->route('inspeksi_fencing.index')
            ->with('success', "Inspeksi {$validated['nomor_inspeksi']} berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiFencing $inspeksiFencing)
    {
        $inspeksiFencing->delete();
        return redirect()
            ->route('inspeksi_fencing.index')
            ->with('success', "Inspeksi {$inspeksiFencing->nomor_inspeksi} berhasil dihapus");
    }
}
