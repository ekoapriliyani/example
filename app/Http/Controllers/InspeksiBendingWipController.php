<?php

namespace App\Http\Controllers;

use App\Models\InspeksiBending;
use App\Models\InspeksiBendingWip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InspeksiBendingWipController extends Controller
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
        $inspeksiBending = InspeksiBending::findOrFail($id);
        return view('inspeksi_bending.wip', ['inspeksi_bending' => $inspeksiBending]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_bending_id'    => 'required|exists:inspeksi_bendings,id',
            'no_material'           => 'required|string|max:255',
            'nama_operator'         => 'required|string|max:255',
            'd_kawat_act'           => 'required|numeric',
            'p_product_act'         => 'required|numeric',
            'l_product_act'         => 'required|numeric',
            't_tekukan'             => 'required|numeric',
            'sudut'                 => 'required|numeric',
            'diagonal'             => 'required|numeric',
            'matchingcrosswire'     => 'required|string|max:255',
            'visual'               => 'required|string|max:255',
            'status'               => 'required|string|max:255',
            'files'                => 'nullable|array',
            'files.*'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        // simpan WIP utama
        $wip = InspeksiBendingWip::create([
            'inspeksi_bending_id' => $validated['inspeksi_bending_id'],
            'user_id'             => Auth::id(),
            'no_material'         => $validated['no_material'],
            'nama_operator'       => $validated['nama_operator'],
            'd_kawat_act'         => $validated['d_kawat_act'],
            'p_product_act'    => $validated['p_product_act'],
            'l_product_act'    => $validated['l_product_act'],
            't_tekukan'        => $validated['t_tekukan'],
            'sudut'            => $validated['sudut'],
            'diagonal'        => $validated['diagonal'],
            'matchingcrosswire' => $validated['matchingcrosswire'],
            'visual'          => $validated['visual'],
            'status'          => $validated['status'],
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
            ->route('inspeksi_bending.show', $request->inspeksi_bending_id)
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
        $wip = InspeksiBendingWip::with(['details', 'inspeksiBending'])->findOrFail($id);
        return view('inspeksi_bending.wip.edit', [
            'inspeksi_bending' => $wip->inspeksiBending,
            'wip' => $wip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wip = InspeksiBendingWip::findOrFail($id);
        $validated = $request->validate([
            'no_material'           => 'required|string|max:255',
            'nama_operator'         => 'required|string|max:255',
            'd_kawat_act'           => 'required|numeric',
            'p_product_act'         => 'required|numeric',
            'l_product_act'         => 'required|numeric',
            't_tekukan'             => 'required|numeric',
            'sudut'                 => 'required|numeric',
            'diagonal'             => 'required|numeric',
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
            't_tekukan'        => $validated['t_tekukan'],
            'sudut'            => $validated['sudut'],
            'diagonal'        => $validated['diagonal'],
            'matchingcrosswire' => $validated['matchingcrosswire'],
            'visual'          => $validated['visual'],
            'status'          => $validated['status'],
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $wip = InspeksiBendingWip::findOrFail($id);
        $wip->update([
            'user_id'               => Auth::id(),
            'no_material'           => $validated['no_material'],
            'nama_operator'         => $validated['nama_operator'],
            'd_kawat_act'         => $validated['d_kawat_act'],
            'p_product_act'    => $validated['p_product_act'],
            'l_product_act'    => $validated['l_product_act'],
            't_tekukan'        => $validated['t_tekukan'],
            'sudut'            => $validated['sudut'],
            'diagonal'        => $validated['diagonal'],
            'matchingcrosswire' => $validated['matchingcrosswire'],
            'visual'          => $validated['visual'],
            'status'          => $validated['status'],
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
                $newFiles[] = $file->store('inspeksi_bending_wip', 'public');
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
        return redirect()->route('inspeksi_bending.show', $wip->inspeksi_bending_id)
            ->with('success', 'Data WIP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $wip = InspeksiBendingWip::findOrFail($id);
        $inspeksiBendingId = $wip->inspeksi_bending_id;

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

        return redirect()->route('inspeksi_bending.show', $inspeksiBendingId)
            ->with('success', 'Data WIP berhasil dihapus.');
    }
}
