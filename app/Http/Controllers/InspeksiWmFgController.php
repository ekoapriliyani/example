<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiWmFgController extends Controller
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
        $inspeksiWm = InspeksiWm::findOrFail($id);
        return view('inspeksi_wm.fg', ['inspeksi_wm' => $inspeksiWm]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_wm_id' => 'required|exists:inspeksi_wms,id',
            'status'         => 'required',
            'qty'            => 'required',
            'weight'         => 'required',
            'files.*'        => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        // simpan FG utama
        $fg = InspeksiWmFg::create([
            'inspeksi_wm_id' => $validated['inspeksi_wm_id'],
            'user_id'        => Auth::id(),
            'status'         => $validated['status'],
            'qty'            => $validated['qty'],
            'weight'         => $validated['weight'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_fg', 'public');
            }
            $fg->update(['files' => $paths]);
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


        return redirect()->route('inspeksi_wm.show', $request->inspeksi_wm_id)
            ->with('success', 'Data FG, detail, dan file berhasil ditambahkan');
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
        $fg = InspeksiWmFg::with(['details', 'inspeksiWm'])->findOrFail($id);

        return view('inspeksi_wm.fg.edit', [
            'inspeksi_wm' => $fg->inspeksiWm,
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

            'detail_description.*' => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*' => 'nullable|integer',
        ]);

        $fg = InspeksiWmFg::findOrFail($id);

        // update data utama
        $fg->update([
            'status' => $request->status,
            'qty' => $request->qty,
            'weight' => $request->weight,
        ]);

        // hapus detail lama
        $fg->details()->delete();

        // simpan detail baru
        if ($request->detail_description) {

            foreach ($request->detail_description as $index => $description) {

                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                // skip kalau kosong semua
                if (
                    empty($description) &&
                    empty($description2) &&
                    empty($qty)
                ) {
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
            ->route('inspeksi_wm.show', $fg->inspeksi_wm_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiWmFg::findOrFail($id);
        $inspeksiWmId = $fg->inspeksi_wm_id; // Simpan ID inspeksi_wm sebelum menghapus FG
        $fg->delete();

        return redirect()->route('inspeksi_wm.show', $inspeksiWmId)
            ->with('success', 'Data FG berhasil dihapus');
    }
}
