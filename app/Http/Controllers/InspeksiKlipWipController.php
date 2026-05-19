<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKlip;
use App\Models\InspeksiKlipWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiKlipWipController extends Controller
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
        $inspeksiKlip = InspeksiKlip::findOrFail($id);
        return view('inspeksi_klip.wip', ['inspeksiKlip' => $inspeksiKlip]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_klip_id' => 'required|exists:inspeksi_klips,id',
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'jml_klip' => '',
            'd_razor' => '',
            'jml_spiral' => '',
            'jarak_antar_klip' => '',
            'visual' => 'required',
            'status' => 'required',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }
        $slitting = InspeksiKlipWip::create([
            'inspeksi_klip_id' => $validated['inspeksi_klip_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'jml_klip' => $validated['jml_klip'],
            'd_razor' => $validated['d_razor'],
            'jml_spiral' => $validated['jml_spiral'],
            'jarak_antar_klip' => $validated['jarak_antar_klip'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $slitting->update([
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
                $slitting->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_klip.show', $validated['inspeksi_klip_id'])
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
        $wip = InspeksiKlipWip::with(['details', 'inspeksiKlip'])->findOrFail($id);

        return view('inspeksi_klip.wip.edit', [
            'inspeksi_klip' => $wip->inspeksiKlip,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wip = InspeksiKlipWip::findOrFail($id);

        $validated = $request->validate([
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'jml_klip' => 'required|numeric',
            'd_razor' => 'required|numeric',
            'jml_spiral' => 'required|numeric',
            'jarak_antar_klip' => 'required|numeric',
            'visual' => 'required',
            'status' => 'required',
        ]);
        $wip->update([
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'jml_klip' => $validated['jml_klip'],
            'd_razor' => $validated['d_razor'],
            'jml_spiral' => $validated['jml_spiral'],
            'jarak_antar_klip' => $validated['jarak_antar_klip'],
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
        // Hapus detail lama
        $wip->details()->delete();
        // Simpan detail baru
        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $wip->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }
        return redirect()->route('inspeksi_klip.show', $wip->inspeksi_klip_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiKlipWip::findOrFail($id);
        $inspeksiKlipId = $wip->inspeksi_klip_id;

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

        return redirect()->route('inspeksi_klip.show', $inspeksiKlipId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
