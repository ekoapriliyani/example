<?php

namespace App\Http\Controllers;

use App\Models\InspeksiBending;
use App\Models\InspeksiBendingFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class InspeksiBendingFgController extends Controller
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
        $inspeksiBending = InspeksiBending::findOrFail($id);
        return view('inspeksi_bending.fg', ['inspeksiBending' => $inspeksiBending]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_bending_id' => 'required|exists:inspeksi_bendings,id',
            'type' => 'required',
            'coating_thickness' => 'required',
            'daya_rekat' => 'required',
            'visual' => 'required',
            'packing' => 'required',
            'label' => 'required',
            'status' => 'required',
            'qty' => 'required',
            'weight' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiBendingFg::create([
            'inspeksi_bending_id' => $validated['inspeksi_bending_id'],
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'coating_thickness' => $validated['coating_thickness'],
            'daya_rekat' => $validated['daya_rekat'],
            'visual' => $validated['visual'],
            'packing'                 => $validated['packing'],
            'label'                 => $validated['label'],
            'status'                 => $validated['status'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_bending_fg', 'public');
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
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }
        return redirect()->route('inspeksi_bending.show', $validated['inspeksi_bending_id'])
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
        $fg = InspeksiBendingFg::with(['inspeksiBending', 'details'])->findOrFail($id);
        return view('inspeksi_bending.fg.edit', [
            'inspeksi_bending' => $fg->inspeksiBending,
            'fg' => $fg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required',
            'coating_thickness' => 'required',
            'daya_rekat' => 'required',
            'visual' => 'required',
            'packing' => 'required',
            'label' => 'required',
            'status' => 'required',
            'qty' => 'required',
            'weight' => 'required',
            'files.*' => 'nullable|file|max:5120',

            'detail_description.*' => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*' => 'nullable|integer',
        ]);

        $fg = InspeksiBendingFg::findOrFail($id);
        $fg->update([
            'status' => $request->status,
            'type' => $request->type,
            'coating_thickness' => $request->coating_thickness,
            'daya_rekat' => $request->daya_rekat,
            'visual' => $request->visual,
            'qty' => $request->qty,
            'weight' => $request->weight,
            'packing' => $request->packing,
            'label' => $request->label,
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
                $newFiles[] = $file->store('inspeksi_bending_fg', 'public');
            }
            $fg->update([
                'files' => $newFiles,
            ]);
        }
        $fg->details()->delete();
        if ($request->detail_description) {
            foreach ($request->detail_description as $index => $description) {
                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                if (empty($description) && empty($description2) && empty($qty)) {
                    continue;
                }

                $fg->details()->create([
                    'description' => $description,
                    'description2' => $description2,
                    'qty' => $qty,
                ]);
            }
        }

        return redirect()
            ->route('inspeksi_bending.show', $fg->inspeksi_bending_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiBendingFg::findOrFail($id);
        $inspeksiBendingId = $fg->inspeksi_bending_id;
        $fg->delete();

        return redirect()->route('inspeksi_bending.show', $inspeksiBendingId)
            ->with('success', 'Data FG berhasil dihapus.');
    }
}
