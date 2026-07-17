<?php

namespace App\Http\Controllers;

use App\Models\InspeksiFencing;
use App\Models\InspeksiFencingFg;
use App\Models\InspeksiFencingFgDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiFencingFgController extends Controller
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
        $inspeksiFencing = InspeksiFencing::findOrFail($id);
        return view('inspeksi_fencing.fg', ['inspeksiFencing' => $inspeksiFencing]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_fencing_id' => 'required|exists:inspeksi_fencings,id',
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
        $fg = InspeksiFencingFg::create([
            'inspeksi_fencing_id' => $validated['inspeksi_fencing_id'],
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
                $paths[] = $file->store('uploads/inspeksi_fencing_fg', 'public');
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
        return redirect()->route('inspeksi_fencing.show', $validated['inspeksi_fencing_id'])
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
    public function edit(InspeksiFencingFg $fg)
    {
        $fg->load(['details', 'inspeksiFencing']);

        return view('inspeksi_fencing.fg.edit', [
            'inspeksiFencing' => $fg->inspeksiFencing,
            'fg'              => $fg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiFencingFg $fg)
    {
        $validated = $request->validate([
            'type'              => 'required',
            'coating_thickness' => 'required',
            'daya_rekat'        => 'required',
            'visual'            => 'required',
            'packing'           => 'required',
            'label'             => 'required',
            'status'            => 'required',
            'qty'               => 'required',
            'weight'            => 'required',

            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',

            'detail_description.*'  => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*'          => 'nullable',
            'detail_id.*'           => 'nullable|integer',
        ]);

        $fg->update([
            'type'              => $validated['type'],
            'coating_thickness' => $validated['coating_thickness'],
            'daya_rekat'        => $validated['daya_rekat'],
            'visual'            => $validated['visual'],
            'packing'           => $validated['packing'],
            'label'             => $validated['label'],
            'status'            => $validated['status'],
            'qty'               => $validated['qty'],
            'weight'            => $validated['weight'],
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
                $newFiles[] = $file->store('uploads/inspeksi_fencing_fg', 'public');
            }
            $fg->update(['files' => $newFiles]);
        }

        $existingIds = $fg->details()->pluck('id')->toArray();
        $submittedIds = $request->input('detail_id', []);
        $toDelete = array_diff($existingIds, $submittedIds);

        if ($toDelete) {
            InspeksiFencingFgDetail::destroy($toDelete);
        }

        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $detailQty     = $request->input('detail_qty', []);

        foreach ($descriptions as $index => $description) {
            if (empty($description) && empty($descriptions2[$index] ?? null) && empty($detailQty[$index] ?? null)) {
                continue;
            }

            $detailId = $submittedIds[$index] ?? null;

            if ($detailId && in_array($detailId, $existingIds)) {
                InspeksiFencingFgDetail::where('id', $detailId)->update([
                    'description'  => $description,
                    'description2' => $descriptions2[$index] ?? null,
                    'qty'          => $detailQty[$index] ?? null,
                ]);
            } else {
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$index] ?? null,
                    'qty'          => $detailQty[$index] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('inspeksi_fencing.show', $fg->inspeksi_fencing_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiFencingFg::findOrFail($id);
        $inspeksiFencingId = $fg->inspeksi_fencing_id; // Simpan ID inspeksi_fencing sebelum menghapus FG
        $fg->delete();

        return redirect()->route('inspeksi_fencing.show', $inspeksiFencingId)
            ->with('success', 'Data FG berhasil dihapus');
    }
}
