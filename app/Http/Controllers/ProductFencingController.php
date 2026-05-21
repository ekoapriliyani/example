<?php

namespace App\Http\Controllers;

use App\Imports\ProductFencingImport;
use App\Models\ProductFencing;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ProductFencingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductFencing::all();
        return view('product_fencing.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productfencing = ProductFencing::findOrFail($id);
        return view('product_fencing.show', ['productfencing' => $productfencing]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productfencing = ProductFencing::findOrFail($id);
        return view('product_fencing.edit', ['productfencing' => $productfencing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productfencing = ProductFencing::findOrFail($id);
        $productfencing->update($request->all());

        return redirect()->route('productfencing.index')->with('success', 'data produk fencing berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productfencing = ProductFencing::findOrFail($id);
        $productfencing->delete();

        return redirect()->route('productfencing.index')->with('success', 'data produk fencing berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(
            new ProductFencingImport(),
            $request->file('file')
        );

        return redirect()
            ->back()
            ->with('success', 'Data Product Fencing berhasil diimport');
    }
}
