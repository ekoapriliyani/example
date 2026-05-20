<?php

namespace App\Http\Controllers;

use App\Models\InspeksiRazorpacking;
use App\Models\InspeksiRazorpackingFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiRazorpackingFgController extends Controller
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
        $inspeksiRazorpacking = InspeksiRazorpacking::findOrFail($id);
        return view('inspeksi_razorpacking.fg', ['inspeksiRazorpacking' => $inspeksiRazorpacking]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_razorpacking_id' => 'required|exists:inspeksi_razorpackings,id',
            'status'                 => 'required',
            'qty'                    => 'required',
            'weight'                 => 'required',
            'visual'                 => 'required',
            'label'                 => 'required',
            'files.*'                => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiRazorpackingFg::create([
            'inspeksi_razorpacking_id' => $validated['inspeksi_razorpacking_id'],
            'user_id'                => Auth::id(),
            'status'                 => $validated['status'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
            'visual'                 => $validated['visual'],
            'label'                 => $validated['label'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_rp_fg', 'public');
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
        return redirect()->route('inspeksi_razorpacking.show', $validated['inspeksi_razorpacking_id'])->with('success', 'Data FG berhasil disimpan.');
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
        $fg = InspeksiRazorpackingFg::with(['details', 'inspeksiRazorpacking'])->findOrFail($id);
        return view('inspeksi_razorpacking.fg.edit', [
            'inspeksi_razorpacking' => $fg->inspeksiRazorpacking,
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
            'visual' => 'required',
            'label' => 'required',

            'files.*' => 'nullable|file|max:5120',

            'detail_description.*' => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*' => 'nullable|integer',
        ]);

        $fg = InspeksiRazorpackingFg::findOrFail($id);
        $fg->update([
            'status' => $request->status,
            'qty' => $request->qty,
            'weight' => $request->weight,
            'visual' => $request->visual,
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
                $newFiles[] = $file->store('inspeksi_razorpacking_fg', 'public');
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
            ->route('inspeksi_razorpacking.show', $fg->inspeksi_razorpacking_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiRazorpackingFg::findOrFail($id);
        $inspeksiRazorpackingId = $fg->inspeksi_razorpacking_id; // Simpan ID inspeksi_razorpacking sebelum menghapus FG
        $fg->delete();

        return redirect()->route('inspeksi_razorpacking.show', $inspeksiRazorpackingId)
            ->with('success', 'Data FG berhasil dihapus');
    }
}
