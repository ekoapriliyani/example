<?php

namespace App\Http\Controllers;

use App\Imports\SubkonImport;
use App\Models\Subkon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubkonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil kata kunci dari input search
        $search = $request->input('search');

        // 2. Query data dengan kondisi pencarian
        $data = Subkon::when($search, function ($query, $search) {
                return $query->where('subkon_id', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('subkon_id', 'desc') // Tetap pakai order by punyamu
            ->paginate(10)
            ->withQueryString(); // Agar saat pindah halaman, hasil search tidak hilang

        // 3. Return ke view
        return view('subkon.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subkon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subkon_id' => 'required',
            'name' => 'required'
        ]);

        Subkon::create([
            'subkon_id' => $validated['subkon_id'],
            'name' => $validated['name']
        ]);
        return redirect()->route('subkon.index')->with('success', 'Data Subkon berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subkon $subkon)
    {
        return view('subkon.show', ['subkon' => $subkon]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subkon $subkon)
    {
        return view('subkon.edit', compact('subkon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subkon $subkon)
    {
        $validated = $request->validate([
            'subkon_id' => 'required',
            'name' => 'required'
        ]);
        $subkon->update($validated);
        return redirect()->route('subkon.index')->with('success', 'Data Subkon berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subkon $subkon)
    {
        $subkon->delete();
        return redirect()->route('subkon.index')->with('success', 'Data subkon berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SubkonImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Subkon berhasil di-import!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
