<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKawatDuri;
use App\Models\InspeksiKawatDuriFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiKawatDuriFgController extends Controller
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
        $inspeksiKd = InspeksiKawatDuri::findOrFail($id);
        return view('inspeksi_kawat_duri.fg', ['inspeksiKd' => $inspeksiKd]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_kawat_duri_id' => 'required|exists:inspeksi_kawat_duris,id',
            'status'                 => 'required',
            'qty'                    => 'required',
            'weight'                 => 'required',
            'files.*'                => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiKawatDuriFg::create([
            'inspeksi_kawat_duri_id' => $validated['inspeksi_kawat_duri_id'],
            'user_id'                => Auth::id(),
            'status'                 => $validated['status'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_kd_fg', 'public');
            }

            $fg->update([
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
                $fg->inspeksiKdFgDetails()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_kawat_duri.show', $validated['inspeksi_kawat_duri_id'])
            ->with('success', 'Data FG berhasil disimpan.');
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
        $fg = InspeksiKawatDuriFg::with(['inspeksiKdFgDetails', 'inspeksiKawatDuri'])->findOrFail($id);
        return view('inspeksi_kawat_duri.fg.edit', [
            'inspeksi_kawat_duri' => $fg->inspeksiKawatDuri,
            'fg' => $fg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string',
            'qty' => 'required|integer',
            'weight' => 'required|numeric',

            'files.*' => 'nullable|file|max:5120',

            'detail_description.*' => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*' => 'nullable|integer',
        ]);

        $fg = InspeksiKawatDuriFg::findOrFail($id);
        $fg->update([
            'status' => $request->status,
            'qty' => $request->qty,
            'weight' => $request->weight,
        ]);
        if ($request->hasFile('files')) {
            if (is_array($fg->files)) {
                foreach ($fg->files as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $newFiles[] = $file->store('inspeksi_kawat_duri_fg', 'public');
            }
            $fg->update([
                'files' => $newFiles,
            ]);
        }
        $fg->inspeksiKdFgDetails()->delete();
        if ($request->detail_description) {
            foreach ($request->detail_description as $index => $description) {
                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                if (empty($description) && empty($description2) && empty($qty)) {
                    continue;
                }

                $fg->inspeksiKdFgDetails()->create([
                    'description' => $description,
                    'description2' => $description2,
                    'qty' => $qty,
                ]);
            }
        }

        return redirect()
            ->route('inspeksi_kawat_duri.show', $fg->inspeksi_kawat_duri_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiKawatDuriFg::findOrFail($id);
        $inspeksiKawatDuriId = $fg->inspeksi_kawat_duri_id; // Simpan ID inspeksi_wm sebelum menghapus FG
        $fg->delete();

        return redirect()->route('inspeksi_kawat_duri.show', $inspeksiKawatDuriId)
            ->with('success', 'Data FG berhasil dihapus');
    }
}
