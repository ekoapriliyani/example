<?php

namespace App\Http\Controllers;

use App\Models\InspeksiSlitting;
use App\Models\InspeksiSlittingWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiSlittingWipController extends Controller
{
    public function create(String $id)
    {
        $inspeksiSlitting = InspeksiSlitting::findOrFail($id);
        return view('inspeksi_slitting.wip', ['inspeksiSlitting' => $inspeksiSlitting]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_slitting_id' => 'required|exists:inspeksi_slittings,id',
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'l_sheetgalvanized' => 'required',
            'tebal_sheetgalvanized' => 'required',
            'weight' => 'nullable',
            'visual' => 'required',
            'status' => 'required',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }
        $slitting = InspeksiSlittingWip::create([
            'inspeksi_slitting_id' => $validated['inspeksi_slitting_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'l_sheetgalvanized' => $validated['l_sheetgalvanized'],
            'tebal_sheetgalvanized' => $validated['tebal_sheetgalvanized'],
            'weight' => $validated['weight'],
            'visual' => $validated['visual'],
            'status' => $validated['status'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_wip', 'public');
            }
            $slitting->update([
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
                $slitting->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('inspeksi_slitting.show', $validated['inspeksi_slitting_id'])
            ->with('success', 'Data WIP berhasil disimpan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wip = InspeksiSlittingWip::with(['details', 'inspeksiSlitting'])->findOrFail($id);

        return view('inspeksi_slitting.wip.edit', [
            'inspeksi_slitting' => $wip->inspeksiSlitting,
            'wip' => $wip,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $wip = InspeksiSlittingWip::findOrFail($id);

        $validated = $request->validate([
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'l_sheetgalvanized' => 'required',
            'tebal_sheetgalvanized' => 'required',
            'weight' => 'nullable',
            'visual' => 'required',
            'status' => 'required',
        ]);
        $wip->update([
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'l_sheetgalvanized' => $validated['l_sheetgalvanized'],
            'tebal_sheetgalvanized' => $validated['tebal_sheetgalvanized'],
            'weight' => $validated['weight'],
            'visual' => $validated['visual'],
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
        // Hapus detail lama
        $wip->details()->delete();
        // Simpan detail baru
        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $wip->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }
        return redirect()->route('inspeksi_slitting.show', $wip->inspeksi_slitting_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiSlittingWip::findOrFail($id);
        $inspeksiSlittingId = $wip->inspeksi_slitting_id;

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

        return redirect()->route('inspeksi_slitting.show', $inspeksiSlittingId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
