<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiWmFgController extends Controller
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
        $inspeksiWm = InspeksiWm::findOrFail($id);
        return view('inspeksi_wm.fg', ['inspeksi_wm' => $inspeksiWm]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_wm_id' => 'required|exists:inspeksi_wms,id',
            'batch_number' => 'required',
            'status' => 'required',
            'qty' => 'required'
        ]);
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }
        InspeksiWmFg::create([
            'inspeksi_wm_id' => $validated['inspeksi_wm_id'],
            'user_id' => Auth::id(),
            'batch_number' => $validated['batch_number'],
            'status' => $validated['status'],
            'qty' => $validated['qty'],
        ]);
        return redirect()->route('inspeksi_wm.show', $request->inspeksi_wm_id)->with('success', 'Data FG berhasil ditambahkan');
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
