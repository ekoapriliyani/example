<?php

namespace App\Http\Controllers;

use App\Models\InspeksiCt;
use App\Models\InspeksiCtWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiCtWipController extends Controller
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
        $inspeksiCt = InspeksiCt::findOrFail($id);
        return view('inspeksi_ct.wip', ['inspeksiCt' => $inspeksiCt]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_ct_id' => 'required|exists:inspeksi_cts,id',
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'l_produk' => 'required',
            'p_produk' => 'required',
            't_produk' => 'required',
            'sudut' => 'required',
            'visual' => 'required',
            'status' => 'required',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }
        $wip = InspeksiCtWip::create([
            'inspeksi_ct_id' => $validated['inspeksi_ct_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'l_produk' => $validated['l_produk'],
            'p_produk' => $validated['p_produk'],
            't_produk' => $validated['t_produk'],
            'sudut' => $validated['sudut'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
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
        // ambil semua array dari request
        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $qty           = $request->input('detail_qty', []);

        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $wip->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }
        return redirect()->route('inspeksi_ct.show', $validated['inspeksi_ct_id'])
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
        $wip = InspeksiCtWip::findOrFail($id);
        $inspeksiCtId = $wip->inspeksi_ct_id;

        // Hapus file terkait jika ada
        if ($wip->files) {
            foreach ($wip->files as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus detail terkait
        $wip->details()->delete();

        // Hapus data WIP
        $wip->delete();

        return redirect()->route('inspeksi_ct.show', $inspeksiCtId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
