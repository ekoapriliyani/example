<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use Illuminate\Http\Request;

class InspeksiWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = InspeksiWm::all();
        return view('inspeksi_wm.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inspeksi_wm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required',
            'tanggal' => 'required'
        ]);

        InspeksiWm::create([
            'nomor_inspeksi' => $validated['nomor_inspeksi'],
            'tanggal' => $validated['tanggal']
        ]);
        return redirect()->route('inspeksi_wm.index')->with('success', 'inspeksi berhasil disimpan');
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
