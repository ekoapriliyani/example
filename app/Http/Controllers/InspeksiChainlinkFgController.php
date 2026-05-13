<?php

namespace App\Http\Controllers;

use App\Models\InspeksiChainlink;
use App\Models\InspeksiChainlinkFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiChainlinkFgController extends Controller
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
        $inspeksiChainlink = InspeksiChainlink::findOrFail($id);
        return view('inspeksi_chainlink.fg', ['inspeksiChainlink' => $inspeksiChainlink]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_chainlink_id' => 'required|exists:inspeksi_chainlinks,id',
            'status'                 => 'required',
            'packing'                 => 'required',
            'label'                 => 'required',
            'qty'                    => 'required',
            'weight'                 => 'required',
            'files.*'                => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiChainlinkFg::create([
            'inspeksi_chainlink_id' => $validated['inspeksi_chainlink_id'],
            'user_id'                => Auth::id(),
            'status'                 => $validated['status'],
            'packing'                 => $validated['packing'],
            'label'                 => $validated['label'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_chainlink_fg', 'public');
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
                $fg->inspeksiChainlinkFgDetails()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_chainlink.show', $validated['inspeksi_chainlink_id'])
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
