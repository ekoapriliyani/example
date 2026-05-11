<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiWmWipController extends Controller
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
    public function create(string $id)
    {
        $inspeksiWm = InspeksiWm::findOrFail($id);
        return view('inspeksi_wm.wip', ['inspeksi_wm' => $inspeksiWm]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_wm_id'    => 'required|exists:inspeksi_wms,id',
            'no_material'       => 'required|string|max:255',
            'nama_operator'     => 'required|string|max:255',
            'd_kawat_act'       => 'required|numeric',
            'selisih_diagonal'  => 'required|numeric',
            'p_product_act'     => 'required|numeric',
            'l_product_act'     => 'required|numeric',
            'p_mesh_act'        => 'required|numeric',
            'l_mesh_act'        => 'required|numeric',
            'torsi_strength'    => 'required|in:OK,NG',
            'status_dimensi'    => 'required|in:OK,NG',
            'visual'    => 'required|in:OK,NG',
            'shear_strength'    => 'nullable|numeric',
            'weight'    => 'required',
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
        $wip = InspeksiWmWip::create([
            'inspeksi_wm_id'   => $validated['inspeksi_wm_id'],
            'user_id'          => Auth::id(),
            'no_material'      => $validated['no_material'],
            'nama_operator'    => $validated['nama_operator'],
            'd_kawat_act'      => $validated['d_kawat_act'],
            'selisih_diagonal' => $validated['selisih_diagonal'],
            'p_product_act'    => $validated['p_product_act'],
            'l_product_act'    => $validated['l_product_act'],
            'p_mesh_act'       => $validated['p_mesh_act'],
            'l_mesh_act'       => $validated['l_mesh_act'],
            'torsi_strength'   => $validated['torsi_strength'],
            'status_dimensi'   => $validated['status_dimensi'],
            'visual'   => $validated['visual'],
            'shear_strength'   => $validated['shear_strength'],
            'weight'   => $validated['weight'],
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
            ->route('inspeksi_wm.show', $request->inspeksi_wm_id)
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
        $wip = InspeksiWmWip::with(['details', 'inspeksiWm'])->findOrFail($id);

        return view('inspeksi_wm.wip.edit', [
            'inspeksi_wm' => $wip->inspeksiWm,
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
            'd_kawat_act'       => 'required|numeric',
            'selisih_diagonal'  => 'required|numeric',
            'p_product_act'     => 'required|numeric',
            'l_product_act'     => 'required|numeric',
            'p_mesh_act'        => 'required|numeric',
            'l_mesh_act'        => 'required|numeric',
            'torsi_strength'    => 'required|in:OK,NG',
            'status_dimensi'    => 'required|in:OK,NG',
            'visual'    => 'required|in:OK,NG',
            'shear_strength'    => 'required',
            'weight'    => 'required',
            'detail_name'       => 'nullable|array',
            'detail_name.*'     => 'nullable|string|max:255',
            'detail_description'   => 'nullable|array',
            'detail_description.*' => 'nullable|string|max:1000',
        ]);
        $wip = InspeksiWmWip::findOrFail($id);
        $wip->update([
            'no_material' => $request->no_material,
            'nama_operator' => $request->nama_operator,
            'd_kawat_act' => $request->d_kawat_act,
            'selisih_diagonal' => $request->selisih_diagonal,
            'p_product_act' => $request->p_product_act,
            'l_product_act' => $request->l_product_act,
            'p_mesh_act' => $request->p_mesh_act,
            'l_mesh_act' => $request->l_mesh_act,
            'torsi_strength' => $request->torsi_strength,
            'status_dimensi' => $request->status_dimensi,
            'visual' => $request->visual,
            'shear_strength' => $request->shear_strength,
            'weight' => $request->weight,
        ]);
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
                $newFiles[] = $file->store('inspeksi_wm_wip', 'public');
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
            ->route('inspeksi_wm.show', $wip->inspeksi_wm_id)
            ->with('success', 'Data WIP berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiWmWip::findOrFail($id);
        $inspeksi_wm_id = $wip->inspeksi_wm_id;

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

        return redirect()->route('inspeksi_wm.show', $inspeksi_wm_id)
            ->with('success', 'Data WIP berhasil dihapus');
    }
}
