<?php

namespace App\Http\Controllers;

use App\Models\InspeksiRazorpacking;
use App\Models\InspeksiRazorpackingFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
