<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionframe;
use App\Models\InspeksiGabionframeWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiGabionframeWipController extends Controller
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
        $inspeksiGabionframe = InspeksiGabionframe::findOrFail($id);
        return view('inspeksi_gabionframe.wip', ['inspeksiGabionframe' => $inspeksiGabionframe]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_gabionframe_id' => 'required|exists:inspeksi_gabionframes,id',
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'p_act' => 'required|numeric',
            'l_act' => 'required|numeric',
            'd_kwtGal_anyam' => '',
            'd_kwtGal_frame' => '',
            'd_kwtPvc_anyam' => '',
            'd_kwtPvc_frame' => '',
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

        $gabionframe = InspeksiGabionframeWip::create([
            'inspeksi_gabionframe_id' => $validated['inspeksi_gabionframe_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'p_act' => $validated['p_act'],
            'l_act' => $validated['l_act'],
            'd_kwtGal_anyam' => $validated['d_kwtGal_anyam'],
            'd_kwtGal_frame' => $validated['d_kwtGal_frame'],
            'd_kwtPvc_anyam' => $validated['d_kwtPvc_anyam'],
            'd_kwtPvc_frame' => $validated['d_kwtPvc_frame'],
            'mesh1' => $validated['mesh1'],
            'mesh2' => $validated['mesh2'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $gabionframe->update([
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
                $gabionframe->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_gabionframe.show', $validated['inspeksi_gabionframe_id'])
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
