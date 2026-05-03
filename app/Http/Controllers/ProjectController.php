<?php

namespace App\Http\Controllers;

use App\Models\Pro;
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
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc') // Tetap pakai order by punyamu
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
        $pros = Pro::orderBy('pro_id')->get();
        return view('project.create', compact('subkons', 'pros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required',
        ]);
        Project::create($validated);
        return redirect()->route('project.index')->with('success', 'Data Project berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('project.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validated);

        return redirect()->route('project.index')->with('success', 'Data Project berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('project.index')->with('success', 'Data Project berhasil dihapus');
    }

    public function import()
    {

    }
}
