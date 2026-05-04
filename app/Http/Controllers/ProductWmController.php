<?php

namespace App\Http\Controllers;

use App\Imports\ProductWmImport;
use App\Models\ProductWm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductWm::all();
        return view('productwm.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productwm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_wm' => 'required',
            'product_wm_id' => 'required',
            'description' => 'required',
            'd_kawat' => 'required',
            'tol_d' => 'required',
            'p_product' => 'required',
            'l_product' => 'required',
            'p_mesh' => 'required',
            'l_mesh' => 'required',
            'tol_mesh' => 'required',
        ]);
        ProductWm::create([
            'jenis_wm' => $validated['jenis_wm'],
            'product_wm_id' => $validated['product_wm_id'],
            'description' => $validated['description'],
            'd_kawat' => $validated['d_kawat'],
            'tol_d' => $validated['tol_d'],
            'p_product' => $validated['p_product'],
            'l_product' => $validated['l_product'],
            'p_mesh' => $validated['p_mesh'],
            'l_mesh' => $validated['l_mesh'],
            'tol_mesh' => $validated['tol_mesh'],
        ]);

        return redirect()->route('productwm.index')->with('success', 'data produk WM berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductWm $productwm)
    {
        return view('productwm.show', ['productwm' => $productwm]);
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
    public function destroy(ProductWm $productwm)
    {
        $productwm->delete();
        return redirect()->route('productwm.index')->with('success', 'data produk wm berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(
            new ProductWmImport(),
            $request->file('file')
        );

        return redirect()
            ->back()
            ->with('success', 'Data Product WM berhasil diimport');
    }
}
