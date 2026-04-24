<?php

namespace App\Http\Controllers;

use App\Models\IncomingBahanBaku;
use App\Models\Supplier;
use Illuminate\Http\Request;

class IncomingBahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IncomingBahanBaku::all();
        return view('incomingbahanbaku.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('incomingbahanbaku.create', compact('suppliers'));
    }

    public function inspeksi()
    {
        return view('incomingbahanbaku.inspeksi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
            'no_sj' => 'required',
            'jml_koil' => 'required',
            'd_kawat' => 'required',
            'tol' => 'required',
            'jenis_kawat' => 'required',
        ]);
        IncomingBahanBaku::create([
            'tanggal' => $validated['tanggal'],
            'supplier_id' => $validated['supplier_id'],
            'no_po' => $validated['no_po'],
            'no_sj' => $validated['no_sj'],
            'jml_koil' => $validated['jml_koil'],
            'd_kawat' => $validated['d_kawat'],
            'tol' => $validated['tol'],
            'jenis_kawat' => $validated['jenis_kawat'],
        ]);
        return redirect()->route('incomingbahanbaku.index')->with('success', 'data incoming berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingBahanBaku $incomingbahanbaku)
    {
        return view('incomingbahanbaku.show', compact('incomingbahanbaku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = IncomingBahanBaku::findOrFail($id);
        $suppliers = Supplier::all();

        return view('incomingbahanbaku.edit', compact('data', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'tanggal' => 'required',
        'supplier_id' => 'required',
        'no_po' => 'required',
        'no_sj' => 'required',
        'jml_koil' => 'required',
        'd_kawat' => 'required',
        'tol' => 'required',
        'jenis_kawat' => 'required',
        ]);

        $item = IncomingBahanBaku::findOrFail($id);

        $item->update($validated);

        return redirect()->route('incomingbahanbaku.index')
            ->with('success', 'Data berhasil diupdate');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
