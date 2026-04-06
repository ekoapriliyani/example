<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mesin::all();
        return view('mesin.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mesin' => 'required',
            'nama_mesin' => 'required'
        ]);

        Mesin::create([
            'id_mesin' => $validated['id_mesin'],
            'nama_mesin' => $validated['nama_mesin']
        ]);
        return redirect()->route('mesin.index')->with('success', 'Data mesin berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesin $mesin)
    {
        return view('mesin.show', ['mesin' => $mesin]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesin $mesin)
    {
        return view('mesin.edit', compact('mesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesin $mesin)
    {
        $validated = request()->validate([
            'id_mesin' => 'required',
            'nama_mesin' => 'required'
        ]);

        $mesin->update($validated);
        return redirect()->route('mesin.index')->with('success', 'data mesin berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesin $mesin)
    {
        $mesin->delete();
        return redirect()->route('mesin.index')->with('success', 'data mesin berhasil dihapus');
    }
}
