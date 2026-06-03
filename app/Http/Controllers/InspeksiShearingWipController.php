<?php

namespace App\Http\Controllers;

use App\Models\InspeksiShearing;
use App\Models\InspeksiShearingWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiShearingWipController extends Controller
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
        $inspeksiShearing = InspeksiShearing::findOrFail($id);
        return view('inspeksi_shearing.wip', ['inspeksi_shearing' => $inspeksiShearing]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_shearing_id' => 'required|exists:inspeksi_shearings,id',
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'p_potong' => 'required|numeric',
            'l_potong' => 'required|numeric',
            'type' => '',
            'mesh1' => '',
            'mesh2' => '',
            'visual' => 'required',
            'status' => 'required',
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

        $shearing = InspeksiShearingWip::create([
            'inspeksi_shearing_id' => $validated['inspeksi_shearing_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'p_potong' => $validated['p_potong'],
            'l_potong' => $validated['l_potong'],
            'mesh1' => $validated['mesh1'],
            'mesh2' => $validated['mesh2'],
            'type' => $validated['type'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $shearing->update([
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
                $shearing->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_shearing.show', $validated['inspeksi_shearing_id'])
            ->with('success', 'Data WIP berhasil disimpan.');
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
