<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKawatDuri;
use App\Models\InspeksiKawatDuriFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiKawatDuriFgController extends Controller
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
        $inspeksiKd = InspeksiKawatDuri::findOrFail($id);
        return view('inspeksi_kawat_duri.fg', ['inspeksiKd' => $inspeksiKd]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_kawat_duri_id' => 'required|exists:inspeksi_kawat_duris,id',
            'status'                 => 'required',
            'qty'                    => 'required',
            'weight'                 => 'required',
            'files.*'                => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiKawatDuriFg::create([
            'inspeksi_kawat_duri_id' => $validated['inspeksi_kawat_duri_id'],
            'user_id'                => Auth::id(),
            'status'                 => $validated['status'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_kd_fg', 'public');
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
                $fg->inspeksiKdFgDetails()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_kawat_duri.show', $validated['inspeksi_kawat_duri_id'])
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
