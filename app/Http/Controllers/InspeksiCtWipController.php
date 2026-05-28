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
            'no_material' => 'string|max:255',
            'nama_operator' => 'required|string|max:255',
            'd_kawat_act' => 'required',
            'l_produk' => 'required',
            'p_produk' => 'required',
            't_produk' => 'nullable',
            'mesh1' => '',
            'mesh2' => '',
            'mesh3' => '',
            'diagonal' => 'required',
            'shear_strength' => '',
            'overhang' => '',
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
            'd_kawat_act' => $validated['d_kawat_act'],
            'l_produk' => $validated['l_produk'],
            'p_produk' => $validated['p_produk'],
            't_produk' => $request->t_produk ?? null,
            'mesh1' => $validated['mesh1'],
            'mesh2' => $validated['mesh2'],
            'mesh3' => $validated['mesh3'],
            'diagonal' => $validated['diagonal'],
            'shear_strength' => $request->shear_strength ?? null,
            'overhang' => $validated['overhang'],
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
        $wip = InspeksiCtWip::with(['details', 'inspeksiCt'])->findOrFail($id);

        return view('inspeksi_ct.wip.edit', [
            'inspeksi_ct' => $wip->inspeksiCt,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'no_material' => 'string|max:255',
            'nama_operator' => 'required|string|max:255',
            'd_kawat_act' => 'required',
            'l_produk' => 'required',
            'p_produk' => 'required',
            't_produk' => 'nullable',
            'mesh1' => '',
            'mesh2' => '',
            'mesh3' => '',
            'diagonal' => 'required',
            'shear_strength' => '',
            'overhang' => '',
            'visual' => 'required',
            // tambahkan validasi untuk field lain jika diperlukan
        ]);

        $wip = InspeksiCtWip::findOrFail($id);
        $wip->update($validated);

        if ($request->hasFile('files')) {
            if (is_array($wip->files)) {
                foreach ($wip->files as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $newFiles[] = $file->store('inspeksi_ct_wip', 'public');
            }
            $wip->update([
                'files' => $newFiles,
            ]);
        }
        $wip->details()->delete();
        if ($request->detail_description) {
            foreach ($request->detail_description as $index => $description) {
                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                if (empty($description) && empty($description2) && empty($qty)) {
                    continue;
                }

                $wip->details()->create([
                    'description' => $description,
                    'description2' => $description2,
                    'qty' => $qty,
                ]);
            }
        }

        return redirect()
            ->route('inspeksi_ct.show', $wip->inspeksi_ct_id)
            ->with('success', 'Data WIP berhasil diupdate.');
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
