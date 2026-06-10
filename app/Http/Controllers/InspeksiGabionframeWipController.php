<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionframe;
use App\Models\InspeksiGabionframeWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiGabionframeWipController extends Controller
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
        $inspeksiGabionframe = InspeksiGabionframe::findOrFail($id);
        return view('inspeksi_gabionframe.wip', ['inspeksiGabionframe' => $inspeksiGabionframe]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_gabionframe_id' => 'required|exists:inspeksi_gabionframes,id',
            'no_material' => 'required|string|max:255',
            'nama_operator' => 'required|string|max:255',
            'p_act' => 'required|numeric',
            'l_act' => 'required|numeric',
            't_act' => '',
            'd_kwtGal_anyam' => '',
            'd_kwtGal_frame' => '',
            'd_kwtPvc_anyam' => '',
            'd_kwtPvc_frame' => '',
            'mesh1' => '',
            'mesh2' => '',
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

        $gabionframe = InspeksiGabionframeWip::create([
            'inspeksi_gabionframe_id' => $validated['inspeksi_gabionframe_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'p_act' => $validated['p_act'],
            'l_act' => $validated['l_act'],
            't_act' => $validated['t_act'],
            'd_kwtGal_anyam' => $validated['d_kwtGal_anyam'],
            'd_kwtGal_frame' => $validated['d_kwtGal_frame'],
            'd_kwtPvc_anyam' => $validated['d_kwtPvc_anyam'],
            'd_kwtPvc_frame' => $validated['d_kwtPvc_frame'],
            'mesh1' => $validated['mesh1'],
            'mesh2' => $validated['mesh2'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $gabionframe->update([
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
                $gabionframe->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_gabionframe.show', $validated['inspeksi_gabionframe_id'])
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
        $wip = InspeksiGabionframeWip::with(['details', 'inspeksiGabionframe'])->findOrFail($id);

        return view('inspeksi_gabionframe.wip.edit', [
            'inspeksi_gabionframe' => $wip->inspeksiGabionframe,
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
            'p_act' => 'required',
            'l_act' => 'required',
            't_act' => '',
            'd_kwtGal_anyam' => '',
            'd_kwtGal_frame' => '',
            'd_kwtPvc_anyam' => '',
            'd_kwtPvc_frame' => '',
            'mesh1' => '',
            'mesh2' => '',
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

        $wip = InspeksiGabionframeWip::findOrFail($id);
        $wip->update([
            'user_id'               => Auth::id(),
            'no_material'           => $validated['no_material'],
            'nama_operator'         => $validated['nama_operator'],
            'p_act'         => $validated['p_act'],
            'l_act'         => $validated['l_act'],
            't_act'         => $validated['t_act'],
            'd_kwtGal_anyam'         => $validated['d_kwtGal_anyam'],
            'd_kwtGal_frame'         => $validated['d_kwtGal_frame'],
            'd_kwtPvc_anyam'         => $validated['d_kwtPvc_anyam'],
            'd_kwtPvc_frame'         => $validated['d_kwtPvc_frame'],
            'mesh1'         => $validated['mesh1'],
            'mesh2'         => $validated['mesh2'],
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
                $newFiles[] = $file->store('inspeksi_gabionframe_wip', 'public');
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

        return redirect()->route('inspeksi_gabionframe.show', $wip->inspeksi_gabionframe_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiGabionframeWip::findOrFail($id);
        $inspeksiGabionframeId = $wip->inspeksi_gabionframe_id;

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

        return redirect()->route('inspeksi_gabionframe.show', $inspeksiGabionframeId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
