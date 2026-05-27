<?php

namespace App\Http\Controllers;

use App\Models\InspeksiFencing;
use App\Models\InspeksiFencingWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiFencingWipController extends Controller
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
        return view('inspeksi_fencing.wip', ['inspeksi_fencing' => $inspeksiFencing]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Cek sesi login terlebih dahulu di posisi paling atas
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        // 2. Jalankan validasi dengan rule yang tepat
        $validated = $request->validate([
            'inspeksi_fencing_id'    => 'required|exists:inspeksi_fencings,id',
            'no_material'           => 'required|string|max:255',
            'nama_operator'         => 'required|string|max:255',
            'd_kawat_act'           => 'required|numeric',
            'p_product_act'         => 'required|numeric',
            'l_product_act'         => 'required|numeric',
            't_product_act'         => 'nullable|numeric', // Diubah menjadi nullable
            'mesh1'                 => 'nullable|numeric',  // Diubah menjadi nullable agar aman
            'mesh2'                 => 'nullable|numeric',
            'mesh3'                 => 'nullable|numeric',
            'mesh4'                 => 'nullable|numeric',
            'mesh5'                 => 'nullable|numeric',
            'mesh6'                 => 'nullable|numeric',
            'diagonal'             => 'required|numeric',
            'shear_strength'       => 'nullable|numeric',
            'overhang'             => 'nullable|numeric',
            'matchingcrosswire'    => 'required|string|max:255',
            'visual'               => 'required|string|max:255',
            'status'               => 'required|string|max:255',
            'files'                => 'nullable|array',
            'files.*'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // 3. Simpan WIP utama menggunakan request direct (?? null) untuk field yang bisa kosong/disabled
        $wip = InspeksiFencingWip::create([
            'inspeksi_fencing_id' => $validated['inspeksi_fencing_id'],
            'user_id'             => Auth::id(),
            'no_material'         => $validated['no_material'],
            'nama_operator'       => $validated['nama_operator'],
            'd_kawat_act'         => $validated['d_kawat_act'],
            'p_product_act'      => $validated['p_product_act'],
            'l_product_act'      => $validated['l_product_act'],

            // SOLUSI AMAN: Menggunakan data request langsung, jika kosong/disabled otomatis diisi null
            't_product_act'      => $request->t_product_act ?? null,
            'mesh1'              => $request->mesh1 ?? null,
            'mesh2'              => $request->mesh2 ?? null,
            'mesh3'              => $request->mesh3 ?? null,
            'mesh4'              => $request->mesh4 ?? null,
            'mesh5'              => $request->mesh5 ?? null,
            'mesh6'              => $request->mesh6 ?? null,
            'diagonal'           => $validated['diagonal'],
            'shear_strength'           => $request->shear_strength ?? null,
            'overhang'           => $validated['overhang'],
            'matchingcrosswire'  => $validated['matchingcrosswire'],
            'visual'            => $validated['visual'],
            'status'            => $validated['status'],
        ]);

        // 4. Simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $wip->update([
                'files' => $paths
            ]);
        }

        // 5. Simpan detail multiple (array)
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

        // Gunakan $validated untuk menjamin parameter ID selalu ada saat redirect
        return redirect()
            ->route('inspeksi_fencing.show', $validated['inspeksi_fencing_id'])
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
        $wip = InspeksiFencingWip::with(['details', 'inspeksiFencing'])->findOrFail($id);
        return view('inspeksi_fencing.wip.edit', [
            'inspeksi_fencing' => $wip->inspeksiFencing,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wip = InspeksiFencingWip::findOrFail($id);
        $validated = $request->validate([
            'no_material'           => 'required|string|max:255',
            'nama_operator'         => 'required|string|max:255',
            'd_kawat_act'           => 'required|numeric',
            'p_product_act'         => 'required|numeric',
            'l_product_act'         => 'required|numeric',
            't_product_act'         => 'required|numeric',
            'mesh1'                 => 'nullable|numeric',
            'mesh2'                 => 'nullable|numeric',
            'mesh3'                 => 'nullable|numeric',
            'mesh4'                 => 'nullable|numeric',
            'mesh5'                 => 'nullable|numeric',
            'mesh6'                 => 'nullable|numeric',
            'diagonal'             => 'required|numeric',
            'shear_strength'       => 'nullable|numeric',
            'overhang'      => 'nullable|numeric',
            'matchingcrosswire'     => 'required|string|max:255',
            'visual'               => 'required|string|max:255',
            'status'               => 'required|string|max:255',
            // validasi file baru (jika ada)
            'files'                => 'nullable|array',
            'files.*'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // update data WIP utama
        $wip->update([
            'no_material'         => $validated['no_material'],
            'nama_operator'       => $validated['nama_operator'],
            'd_kawat_act'         => $validated['d_kawat_act'],
            'p_product_act'    => $validated['p_product_act'],
            'l_product_act'    => $validated['l_product_act'],
            't_product_act'        => $validated['t_product_act'],
            'mesh1'            => $validated['mesh1'],
            'mesh2'            => $validated['mesh2'],
            'mesh3'            => $validated['mesh3'],
            'mesh4'            => $validated['mesh4'],
            'mesh5'            => $validated['mesh5'],
            'mesh6'            => $validated['mesh6'],
            'diagonal'        => $validated['diagonal'],
            'shear_strength'  => $validated['shear_strength'],
            'overhang'        => $validated['overhang'],
            'matchingcrosswire' => $validated['matchingcrosswire'],
            'visual'          => $validated['visual'],
            'status'          => $validated['status'],
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

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
                $newFiles[] = $file->store('inspeksi_fencing_wip', 'public');
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
        return redirect()->route('inspeksi_fencing.show', $wip->inspeksi_fencing_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiFencingWip::findOrFail($id);
        $inspeksiFencingId = $wip->inspeksi_fencing_id;

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

        return redirect()->route('inspeksi_fencing.show', $inspeksiFencingId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
