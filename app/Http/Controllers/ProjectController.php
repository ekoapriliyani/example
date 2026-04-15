<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Subkon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil kata kunci dari input search
        $search = $request->input('search');

        // 2. Query data dengan kondisi pencarian
        $data = Project::when($search, function ($query, $search) {
                return $query->where('project_id', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('project_id', 'desc') // Tetap pakai order by punyamu
            ->paginate(10)
            ->withQueryString(); // Agar saat pindah halaman, hasil search tidak hilang

        // 3. Return ke view
        return view('project.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subkons = Subkon::all(); // Ambil semua data subkon
        return view('project.create', compact('subkons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|unique:projects',
            'subkon_id'  => 'required|exists:subkons,id',
            'name'       => 'required',
            'no_pro'     => 'required',
            'qty'        => 'required|numeric',
        ]);
        Project::create($validated);
        return redirect()->route('project.index')->with('success', 'Data Project berhasil disimpan');
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

    public function import()
    {

    }
}
