<?php

namespace App\Http\Controllers;

use App\Models\IncomingProject;
use App\Models\IncomingProjectInspeksi;
use App\Models\Material;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IncomingProject::all();
        return view('incomingproject.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = IncomingProject::where('nomor_inspeksi', 'like', "INP{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INP{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INP{$tahunBulan}{$nextNumber}";
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('incomingproject.create', compact('nextNomor','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_inspeksi' => 'required|unique:incoming_projects,nomor_inspeksi',
            'tanggal' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'no_po' => 'required|string|max:255',
            'no_sj' => 'required|string|max:255',
        ]);

        IncomingProject::create($validatedData);

        return redirect()->route('incomingproject.index')->with('success', 'Inspeksi incoming project berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingProject $incomingproject)
    {
        return view('incomingproject.show', compact('incomingproject'));
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

    public function createInspeksi($id){
        $incomingproject = IncomingProject::findOrFail($id);
        $materials = Material::all();
        return view('incomingproject.inspeksi', compact('incomingproject', 'materials'));
    }

    // store inspeksi
    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'visual'  => 'required|in:OK,NG',
            'material_id' => 'required|exists:materials,id',
            'files'   => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        $inproject = IncomingProjectInspeksi::create([
            'incoming_project_id' => $id,
            'user_id' => Auth::id(),
            'visual' => $validated['visual'],
            'material_id' => $validated['material_id'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $paths[] = $file->storeAs(
                    'uploads/incomingproject',
                    $name,
                    'public'
                );
            }

            $inproject->update([
                'files' => $paths
            ]);
        }

        return redirect()
            ->route('incomingproject.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
    }
}