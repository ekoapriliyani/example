<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKawatDuri;
use App\Models\InspeksiKawatDuriWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiKawatDuriWipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $id)
    {
        $inspeksiKawatDuri = InspeksiKawatDuri::findOrFail($id);
        return view('inspeksi_kawat_duri.wip', ['inspeksiKawatDuri' => $inspeksiKawatDuri]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_kawat_duri_id' => 'required|exists:inspeksi_kawat_duris,id',
            'no_material' => 'string|max:255',
            'nama_operator' => 'nullable|string|max:255',
            'd_inti_kd' => 'required|numeric',
            'd_pvc_kd' => 'nullable|numeric',
            'd_inti_kj' => 'nullable|numeric',
            'd_pvc_kj' => 'nullable|numeric',
            'jarak_duri' => 'nullable|numeric',
            'jml_jalinan_duri' => 'nullable|numeric',
            'sudut_ujung_duri' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'jml_counter' => 'nullable|numeric',
            'status' => 'required|string|max:255',
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

        $wip = InspeksiKawatDuriWip::create([
            'inspeksi_kawat_duri_id' => $validated['inspeksi_kawat_duri_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'd_inti_kd' => $validated['d_inti_kd'],
            'd_pvc_kd' => $validated['d_pvc_kd'],
            'd_inti_kj' => $validated['d_inti_kj'],
            'd_pvc_kj' => $validated['d_pvc_kj'],
            'jarak_duri' => $validated['jarak_duri'],
            'jml_jalinan_duri' => $validated['jml_jalinan_duri'],
            'sudut_ujung_duri' => $validated['sudut_ujung_duri'],
            'weight' => $validated['weight'],
            'jml_counter' => $validated['jml_counter'],
            'status' => $validated['status'],
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
                $wip->inspeksiKdWipDetails()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_kawat_duri.show', $validated['inspeksi_kawat_duri_id'])
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
        $wip = InspeksiKawatDuriWip::with(['inspeksiKdWipDetails', 'inspeksiKawatDuri'])->findOrFail($id);

        return view('inspeksi_kawat_duri.wip.edit', [
            'inspeksi_kawat_duri' => $wip->inspeksiKawatDuri,
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
            'd_inti_kd' => 'required|numeric',
            'd_pvc_kd' => '',
            'd_inti_kj' => '',
            'd_pvc_kj' => '',
            'jarak_duri' => 'required|numeric',
            'jml_jalinan_duri' => 'required|numeric',
            'sudut_ujung_duri' => 'required|numeric',
            'weight' => 'required|numeric',
            'jml_counter' => 'required|numeric',
            'status' => 'required|string|max:255',
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

        $wip = InspeksiKawatDuriWip::findOrFail($id);
        $wip->update([
            'user_id'               => Auth::id(),
            'no_material'           => $validated['no_material'],
            'nama_operator'         => $validated['nama_operator'],
            'd_inti_kd' => $validated['d_inti_kd'],
            'd_pvc_kd' => $validated['d_pvc_kd'],
            'd_inti_kj' => $validated['d_inti_kj'],
            'd_pvc_kj' => $validated['d_pvc_kj'],
            'jarak_duri'           => $validated['jarak_duri'],
            'jml_jalinan_duri'     => $validated['jml_jalinan_duri'],
            'sudut_ujung_duri'     => $validated['sudut_ujung_duri'],
            'jml_counter'          => $validated['jml_counter'],
            'weight'               => $validated['weight'],
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
                $newFiles[] = $file->store('inspeksi_kawat_duri_wip', 'public');
            }
            $wip->update([
                'files' => $newFiles,
            ]);
        }

        $wip->inspeksiKdWipDetails()->delete();
        if ($request->detail_description) {
            foreach ($request->detail_description as $index => $description) {
                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                if (empty($description) && empty($description2) && empty($qty)) {
                    continue;
                }

                $wip->inspeksiKdWipDetails()->create([
                    'description' => $description,
                    'description2' => $description2,
                    'qty' => $qty,
                ]);
            }
        }

        return redirect()->route('inspeksi_kawat_duri.show', $wip->inspeksi_kawat_duri_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiKawatDuriWip::findOrFail($id);
        $inspeksiKawatDuriId = $wip->inspeksi_kawat_duri_id;

        // Hapus file terkait jika ada
        if ($wip->files) {
            foreach ($wip->files as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus detail terkait
        $wip->inspeksiKdWipDetails()->delete();

        // Hapus data WIP
        $wip->delete();

        return redirect()->route('inspeksi_kawat_duri.show', $inspeksiKawatDuriId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
