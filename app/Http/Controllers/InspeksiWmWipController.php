<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'no_material'    => 'required',
            'nama_operator'  => 'required',
            'd_kawat_act'  => 'required',
            'selisih_diagonal'  => 'required',
            'p_product_act'  => 'required',
            'l_product_act'  => 'required',
            'p_mesh_act'  => 'required',
            'l_mesh_act'  => 'required',
            'torsi_strength'  => 'required',
            'status_dimensi'  => 'required',
        ]);

        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        // Simpan data
        InspeksiWmWip::create([
            'inspeksi_wm_id' => $validated['inspeksi_wm_id'],
            'user_id'        => Auth::id(), // Mengambil ID dari user yang sedang login
            'no_material'    => $validated['no_material'],
            'nama_operator'  => $validated['nama_operator'],
            'd_kawat_act' => $validated['d_kawat_act'],
            'selisih_diagonal' => $validated['selisih_diagonal'],
            'p_product_act' => $validated['p_product_act'],
            'l_product_act' => $validated['l_product_act'],
            'p_mesh_act' => $validated['p_mesh_act'],
            'l_mesh_act' => $validated['l_mesh_act'],
            'torsi_strength' => $validated['torsi_strength'],
            'status_dimensi' => $validated['status_dimensi'],
        ]);

        return redirect()->route('inspeksi_wm.show', $request->inspeksi_wm_id)
                        ->with('success', 'Data WIP berhasil ditambahkan!');
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
