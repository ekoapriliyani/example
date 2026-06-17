<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionanyam;
use App\Models\InspeksiGabionanyamWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiGabionanyamWipController extends Controller
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
        $inspeksiGabionanyam = InspeksiGabionanyam::findOrFail($id);
        return view('inspeksi_gabionanyam.wip', ['inspeksiGabionanyam' => $inspeksiGabionanyam]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_gabionanyam_id' => 'required|exists:inspeksi_gabionanyams,id',
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'l1_act' => 'required|numeric',
            'l2_act' => 'required|numeric',
            'd_anyam' => '',
            'd_frame' => '',
            'd_anyam_pvc' => '',
            'd_frame_pvc' => '',
            'mesh1' => '',
            'mesh2' => '',
            'p_lilitan' => '',
            'jml_lilitan' => '',
            'visual' => 'required',
            'status' => 'required',
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

        $gabionanyam = InspeksiGabionanyamWip::create([
            'inspeksi_gabionanyam_id' => $validated['inspeksi_gabionanyam_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'type' => $validated['type'],
            'l1_act' => $validated['l1_act'],
            'l2_act' => $validated['l2_act'],
            'd_anyam' => $validated['d_anyam'],
            'd_frame' => $validated['d_frame'],
            'd_anyam_pvc' => $validated['d_anyam_pvc'],
            'd_frame_pvc' => $validated['d_frame_pvc'],
            'mesh1' => $validated['mesh1'],
            'mesh2' => $validated['mesh2'],
            'p_lilitan' => $validated['p_lilitan'],
            'jml_lilitan' => $validated['jml_lilitan'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $gabionanyam->update([
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
                $gabionanyam->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_gabionanyam.show', $validated['inspeksi_gabionanyam_id'])
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
        $wip = InspeksiGabionanyamWip::with(['details', 'inspeksiGabionanyam'])->findOrFail($id);

        return view('inspeksi_gabionanyam.wip.edit', [
            'inspeksi_gabionanyam' => $wip->inspeksiGabionanyam,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'type' => '',
            'l1_act' => 'required',
            'l2_act' => 'required',
            'd_anyam' => '',
            'd_frame' => '',
            'd_anyam_pvc' => '',
            'd_frame_pvc' => '',
            'mesh1' => '',
            'mesh2' => '',
            'p_lilitan' => '',
            'jml_lilitan' => '',
            'visual' => 'required',
            'status' => 'required',
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

        $wip = InspeksiGabionanyamWip::findOrFail($id);
        $wip->update([
            'user_id'               => Auth::id(),
            'no_material'           => $validated['no_material'],
            'nama_operator'         => $validated['nama_operator'],
            'type'         => $validated['type'],
            'l1_act'         => $validated['l1_act'],
            'l2_act'         => $validated['l2_act'],
            'd_anyam'         => $validated['d_anyam'],
            'd_frame'         => $validated['d_frame'],
            'd_anyam_pvc'         => $validated['d_anyam_pvc'],
            'd_frame_pvc'         => $validated['d_frame_pvc'],
            'mesh1'         => $validated['mesh1'],
            'mesh2'         => $validated['mesh2'],
            'p_lilitan'         => $validated['p_lilitan'],
            'jml_lilitan'         => $validated['jml_lilitan'],
            'visual'         => $validated['visual'],
            'status'               => $validated['status'],
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
                $newFiles[] = $file->store('inspeksi_gabionanyam_wip', 'public');
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

        return redirect()->route('inspeksi_gabionanyam.show', $wip->inspeksi_gabionanyam_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiGabionanyamWip::findOrFail($id);
        $inspeksiGabionanyamId = $wip->inspeksi_gabionanyam_id;

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

        return redirect()->route('inspeksi_gabionanyam.show', $inspeksiGabionanyamId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
