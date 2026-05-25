<?php

namespace App\Http\Controllers;

use App\Models\InspeksiFencing;
use App\Models\InspeksiFencingFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiFencingFgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $id)
    {
        $inspeksiFencing = InspeksiFencing::findOrFail($id);
        return view('inspeksi_fencing.fg', ['inspeksiFencing' => $inspeksiFencing]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_fencing_id' => 'required|exists:inspeksi_fencings,id',
            'type' => 'required',
            'coating_thickness' => 'required',
            'daya_rekat' => 'required',
            'visual' => 'required',
            'packing' => 'required',
            'label' => 'required',
            'status' => 'required',
            'qty' => 'required',
            'weight' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiFencingFg::create([
            'inspeksi_fencing_id' => $validated['inspeksi_fencing_id'],
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'coating_thickness' => $validated['coating_thickness'],
            'daya_rekat' => $validated['daya_rekat'],
            'visual' => $validated['visual'],
            'packing'                 => $validated['packing'],
            'label'                 => $validated['label'],
            'status'                 => $validated['status'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_fencing_fg', 'public');
            }

            $fg->update([
                'files' => $paths
            ]);
        }

        // simpan detail multiple (array)
        // ambil semua array dari request
        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $qty           = $request->input('detail_qty', []);

        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }
        return redirect()->route('inspeksi_fencing.show', $validated['inspeksi_fencing_id'])
            ->with('success', 'Data FG berhasil disimpan.');
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
    public function edit(string $id)
    {
        //
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
        //
    }
}
