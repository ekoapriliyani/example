<?php

namespace App\Http\Controllers;

use App\Models\InspeksiPound;
use App\Models\InspeksiPoundWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiPoundWipController extends Controller
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
        $inspeksiPound = InspeksiPound::findOrFail($id);
        return view('inspeksi_pound.wip', ['inspeksiPound' => $inspeksiPound]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_pound_id' => 'required|exists:inspeksi_pounds,id',
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'tebal_blade' => '',
            'p_blade' => '',
            'l_blade' => '',
            'jarak_blade' => '',
            'd_roll' => '',
            'daya_jepit' => '',
            // 'weight' => '',
            'visual' => 'required',
            'status' => 'required',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }
        $slitting = InspeksiPoundWip::create([
            'inspeksi_pound_id' => $validated['inspeksi_pound_id'],
            'user_id' => Auth::id(),
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'tebal_blade' => $validated['tebal_blade'],
            'p_blade' => $validated['p_blade'],
            'l_blade' => $validated['l_blade'],
            'jarak_blade' => $validated['jarak_blade'],
            'd_roll' => $validated['d_roll'],
            'daya_jepit' => $validated['daya_jepit'],
            // 'weight' => $validated['weight'],
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

        return redirect()->route('inspeksi_pound.show', $validated['inspeksi_pound_id'])
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
        $wip = InspeksiPoundWip::with(['details', 'inspeksiPound'])->findOrFail($id);

        return view('inspeksi_pound.wip.edit', [
            'inspeksi_pound' => $wip->inspeksiPound,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wip = InspeksiPoundWip::findOrFail($id);

        $validated = $request->validate([
            'no_material' => '',
            'nama_operator' => 'required|string|max:255',
            'tebal_blade' => 'required',
            'p_blade' => 'required',
            'l_blade' => 'required',
            'jarak_blade' => 'required',
            'd_roll' => 'required',
            'daya_jepit' => 'required',
            // 'weight' => 'nullable',
            'visual' => 'required',
            'status' => 'required',
        ]);
        $wip->update([
            'no_material' => $validated['no_material'],
            'nama_operator' => $validated['nama_operator'],
            'tebal_blade' => $validated['tebal_blade'],
            'p_blade' => $validated['p_blade'],
            'l_blade' => $validated['l_blade'],
            'jarak_blade' => $validated['jarak_blade'],
            'd_roll' => $validated['d_roll'],
            'daya_jepit' => $validated['daya_jepit'],
            // 'weight' => $validated['weight'],
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
        return redirect()->route('inspeksi_pound.show', $wip->inspeksi_pound_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wip = InspeksiPoundWip::findOrFail($id);
        $inspeksiPoundId = $wip->inspeksi_pound_id;

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

        return redirect()->route('inspeksi_pound.show', $inspeksiPoundId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
