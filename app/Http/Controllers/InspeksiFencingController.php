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
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiFencing::where('nomor_inspeksi', 'like', "INSFEN{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSFEN{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSFEN{$tahunBulan}{$nextNumber}";

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
            'nomor_inspeksi' => 'required|unique:inspeksi_fencings,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => '',
            'satuan' => 'required',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiFencing::where('nomor_inspeksi', 'like', "INSFEN{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSFEN{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSFEN{$tahunBulan}{$nextNumber}";

        InspeksiFencing::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'], // ini FK ke pros.id
            'shift' => $validated['shift'],
            'mesin_id' => $validated['mesin_id'] ?? null,
            'total_prod' => $validated['total_prod'] ?? null,
            'satuan' => $validated['satuan'],
        ]);

        return redirect()
            ->route('inspeksi_fencing.index')
            ->with('success', "Inspeksi {$nomorOtomatis} berhasil disimpan");
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
