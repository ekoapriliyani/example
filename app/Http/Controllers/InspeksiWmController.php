<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiWm::when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
                            // ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10) // Ini yang menghasilkan objek Paginator
            ->withQueryString();

        return view('inspeksi_wm.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        
        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "INSWM{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSWM{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int)$lastNumberStr + 1;
        }

        $nextNomor = "INSWM{$tahunBulan}{$nextNumber}";
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderBy('pro_id')->get();

        return view('inspeksi_wm.create', compact('nextNomor', 'mesins', 'pros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'shear_strength' => 'required|numeric',
            'mesin_id' => 'required|exists:mesins,id',
        ]);

        // 1. Ambil Tahun dan Bulan dari tanggal yang diinput (atau tanggal hari ini)
        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym'); // Hasilnya: 202604

        // 2. Cari nomor terakhir yang punya prefix tahun-bulan tersebut
        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "INSWM{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (!$lastRecord) {
            // Jika belum ada data di bulan ini, mulai dari 1
            $nextNumber = 1;
        } else {
            // Ambil nomor_inspeksi terakhir (misal INSWM2026045), 
            // buang teks "INSWM202604", sisanya adalah angka urut
            $lastNumberStr = str_replace("INSWM{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int)$lastNumberStr + 1;
        }

        // 3. Gabungkan semuanya: INSWM + 202604 + 1
        $nomorOtomatis = "INSWM{$tahunBulan}{$nextNumber}";

        $pro = Pro::findOrFail($validated['pro_id']);
        InspeksiWm::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'grade' => $validated['grade'],
            'type_coating' => $validated['type_coating'],
            'shear_strength' => $validated['shear_strength'],
            'mesin_id' => $validated['mesin_id'],
        ]);

        return redirect()->route('inspeksi_wm.index')->with('success', "Inspeksi $nomorOtomatis berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiWm $inspeksi_wm)
    {
        return view('inspeksi_wm.show', ['inspeksi_wm' => $inspeksi_wm]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWm $inspeksi_wm)
    {
        $pros = Pro::orderBy('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();
        return view('inspeksi_wm.edit', compact('inspeksi_wm', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWm $inspeksi_wm)
    {
        $validated = $request->validate([
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'shear_strength' => 'required|numeric',
            'mesin_id' => 'required|exists:mesins,id',
        ]);

        $inspeksi_wm->update([
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'grade' => $validated['grade'],
            'type_coating' => $validated['type_coating'],
            'shear_strength' => $validated['shear_strength'],
            'mesin_id' => $validated['mesin_id'],
        ]);

        return redirect()->route('inspeksi_wm.index')
            ->with('success', 'Data inspeksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiWm $inspeksiWm)
    {
        $inspeksiWm->delete();
        return redirect()->route('inspeksi_wm.index')->with('success', 'inspeksi berhasil dihapus');
    }
}
