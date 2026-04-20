<?php

namespace App\Http\Controllers;

use App\Imports\MaterialImport;
use App\Models\Material;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Tambahkan parameter Request
    {
        // 1. Ambil kata kunci dari input search
        $search = $request->input('search');

        // 2. Query data dengan kondisi pencarian
        $data = Material::when($search, function ($query, $search) {
                return $query->where('item_id', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('item_id', 'desc') // Tetap pakai order by punyamu
            ->paginate(10)
            ->withQueryString(); // Agar saat pindah halaman, hasil search tidak hilang

        // 3. Return ke view
        return view('material.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required',
            'description' => 'required'
        ]);

        Material::create([
            'item_id' => $validated['item_id'],
            'description' => $validated['description']
        ]);

        return redirect()->route('material.index')->with('success', 'Material berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        // $material = Material::findOrFail($id);
        return view('material.show', ['material' => $material]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('material.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'item_id' => 'required',
            'description' => 'required'
        ]);
        
        $material->update($validated);
        return redirect()->route('material.index')->with('success', 'Material berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('material.index')->with('success', 'material berhasil dihapus');
    }

    public function import(Request $request) 
    {
        // Validasi file harus excel/csv
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MaterialImport, $request->file('file'));
            return redirect()->route('material.index')->with('success', 'Data material berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->route('material.index')->with('error', 'Gagal impor data: ' . $e->getMessage());
        }
    }

}
