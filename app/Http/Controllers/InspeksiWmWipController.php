<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmWip;
use Illuminate\Http\Request;

class InspeksiWmWipController extends Controller
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
    public function create(string $id)
    {
        $inspeksiWm = InspeksiWm::findOrFail($id);
        return view('inspeksi_wm.wip', ['inspeksi_wm' => $inspeksiWm]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_wm_id' => 'required|exists:inspeksi_wms,id',
            'no_material' => 'required',
            'nama_operator' => 'required'
        ]);
        InspeksiWmWip::create([
            'inspeksi_wm_id' => $validated['inspeksi_wm_id'],
            'user_id' => 2,
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator']
        ]);
        return redirect()->route('inspeksi_wm.show', $request->inspeksi_wm_id)
    ->with('success', 'Data WIP berhasil disimpan');

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
