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
            'inspeksi_wm_id'    => 'required|exists:inspeksi_wms,id',
            'no_material'       => 'required|string|max:255',
            'nama_operator'     => 'required|string|max:255',
            'd_kawat_act'       => 'required|numeric',
            'selisih_diagonal'  => 'required|numeric',
            'p_product_act'     => 'required|numeric',
            'l_product_act'     => 'required|numeric',
            'p_mesh_act'        => 'required|numeric',
            'l_mesh_act'        => 'required|numeric',
            'torsi_strength'    => 'required|in:OK,NG',
            'status_dimensi'    => 'required|in:OK,NG',
            'visual'    => 'required|in:OK,NG',

            'detail_name'       => 'nullable|array',
            'detail_name.*'     => 'nullable|string|max:255',
            'detail_description'   => 'nullable|array',
            'detail_description.*' => 'nullable|string|max:1000',

            'files'             => 'nullable|array',
            'files.*'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        // simpan WIP utama
        $wip = InspeksiWmWip::create([
            'inspeksi_wm_id'   => $validated['inspeksi_wm_id'],
            'user_id'          => Auth::id(),
            'no_material'      => $validated['no_material'],
            'nama_operator'    => $validated['nama_operator'],
            'd_kawat_act'      => $validated['d_kawat_act'],
            'selisih_diagonal' => $validated['selisih_diagonal'],
            'p_product_act'    => $validated['p_product_act'],
            'l_product_act'    => $validated['l_product_act'],
            'p_mesh_act'       => $validated['p_mesh_act'],
            'l_mesh_act'       => $validated['l_mesh_act'],
            'torsi_strength'   => $validated['torsi_strength'],
            'status_dimensi'   => $validated['status_dimensi'],
            'visual'   => $validated['visual'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }

            $wip->update([
                'files' => $paths
            ]);
        }

        // simpan detail multiple (array)
        $descriptions = $request->input('detail_description', []);
        $qty = $request->input('detail_qty', []);

        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $wip->details()->create([
                    'description' => $description,
                    'qty' => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('inspeksi_wm.show', $request->inspeksi_wm_id)
            ->with('success', 'Data WIP, detail, dan file berhasil ditambahkan');
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
