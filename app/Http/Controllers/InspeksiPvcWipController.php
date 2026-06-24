<?php

namespace App\Http\Controllers;

use App\Models\InspeksiPvc;
use App\Models\InspeksiPvcWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiPvcWipController extends Controller
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
        $inspeksiPvc = InspeksiPvc::findOrFail($id);
        return view('inspeksi_pvc.wip', ['inspeksi_pvc' => $inspeksiPvc]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_pvc_id'    => 'required|exists:inspeksi_pvcs,id',
            'no_material'       => 'required|string|max:255',
            'nama_operator'     => 'required|string|max:255',
            'c1'       => 'required|numeric',
            'c2'       => 'required|numeric',
            'c3'       => 'required|numeric',
            'c4'       => 'required|numeric',
            'ch'       => 'required|numeric',
            'd_kawat_inti'       => 'required|numeric',
            'd_kawat_pvc'       => 'required|numeric',
            'penyimpangan'       => 'required|numeric',
            'warna'    => 'required',
            'uji_lilit'    => 'required|in:OK,NG',
            'visual'    => 'required|in:OK,NG',
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

        // simpan WIP utama
        $wip = InspeksiPvcWip::create([
            'inspeksi_pvc_id'   => $validated['inspeksi_pvc_id'],
            'user_id'          => Auth::id(),
            'no_material'      => $validated['no_material'],
            'nama_operator'    => $validated['nama_operator'],
            'c1'    => $validated['c1'],
            'c2'    => $validated['c2'],
            'c3'    => $validated['c3'],
            'c4'    => $validated['c4'],
            'ch'    => $validated['ch'],
            'd_kawat_inti'    => $validated['d_kawat_inti'],
            'd_kawat_pvc'    => $validated['d_kawat_pvc'],
            'penyimpangan'    => $validated['penyimpangan'],
            'warna'    => $validated['warna'],
            'uji_lilit'    => $validated['uji_lilit'],
            'visual'   => $validated['visual'],
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
        return redirect()
            ->route('inspeksi_pvc.show', $request->inspeksi_pvc_id)
            ->with('success', 'Data WIP, detail, dan file berhasil ditambahkan');
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
        $wip = InspeksiPvcWip::with(['details', 'inspeksiPvc'])->findOrFail($id);

        return view('inspeksi_pvc.wip.edit', [
            'inspeksi_pvc' => $wip->inspeksiPvc,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'no_material'       => 'required|string|max:255',
            'nama_operator'     => 'required|string|max:255',
            'c1'       => 'required|numeric',
            'c2'       => 'required|numeric',
            'c3'       => 'required|numeric',
            'c4'       => 'required|numeric',
            'ch'       => 'required|numeric',
            'd_kawat_inti'       => 'required|numeric',
            'd_kawat_pvc'       => 'required|numeric',
            'penyimpangan'       => 'required|numeric',
            'warna'       => 'required',
            'uji_lilit'       => 'required',
            'visual'    => 'required|in:OK,NG',
            'detail_name'       => 'nullable|array',
            'detail_name.*'     => 'nullable|string|max:255',
            'detail_description'   => 'nullable|array',
            'detail_description.*' => 'nullable|string|max:1000',
        ]);
        $wip = InspeksiPvcWip::findOrFail($id);
        $wip->update([
            'no_material' => $request->no_material,
            'nama_operator' => $request->nama_operator,
            'c1' => $request->c1,
            'c2' => $request->c2,
            'c3' => $request->c3,
            'c4' => $request->c4,
            'ch' => $request->ch,
            'd_kawat_inti' => $request->d_kawat_inti,
            'd_kawat_pvc' => $request->d_kawat_pvc,
            'warna' => $request->warna,
            'uji_lilit' => $request->uji_lilit,
            'visual' => $request->visual,
        ]);
        if ($request->hasFile('files')) {
            if (is_array($wip->files)) {
                foreach ($wip->files as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
            $nepvciles = [];
            foreach ($request->file('files') as $file) {
                $nepvciles[] = $file->store('inspeksi_pvc_wip', 'public');
            }
            $wip->update([
                'files' => $nepvciles,
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
            ->route('inspeksi_pvc.show', $wip->inspeksi_pvc_id)
            ->with('success', 'Data WIP berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiPvcWip::findOrFail($id);
        $inspeksi_pvc_id = $wip->inspeksi_pvc_id;

        // hapus file dari storage
        if (is_array($wip->files)) {
            foreach ($wip->files as $filePath) {
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
            }
        }

        // hapus data WIP
        $wip->delete();

        return redirect()->route('inspeksi_pvc.show', $inspeksi_pvc_id)
            ->with('success', 'Data WIP berhasil dihapus');
    }
}
