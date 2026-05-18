<?php

namespace App\Http\Controllers;

use App\Imports\ProductCtImport;
use App\Models\ProductCt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductCtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductCt::all();
        return view('productct.index', compact('data'));
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(
            new ProductCtImport(),
            $request->file('file')
        );

        return redirect()
            ->back()
            ->with('success', 'Data Product CTCL berhasil diimport');
    }
}
