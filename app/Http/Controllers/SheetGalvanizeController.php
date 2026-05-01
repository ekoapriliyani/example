<?php

namespace App\Http\Controllers;

use App\Models\InspeksiSheetGalvanize;
use App\Models\SheetGalvanize;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SheetGalvanizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SheetGalvanize::all();
        return view('sheetgalvanize.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = SheetGalvanize::where('nomor_inspeksi', 'like', "INSG{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSG{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSG{$tahunBulan}{$nextNumber}";
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('sheetgalvanize.create', compact('nextNomor','suppliers'));
    }

    public function createInspeksi($id){
        $sheetgalvanize = SheetGalvanize::findOrFail($id);

        return view('sheetgalvanize.inspeksi', compact('sheetgalvanize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required',
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
        ]);
        SheetGalvanize::create([
            'nomor_inspeksi' => $validated['nomor_inspeksi'],
            'tanggal' => $validated['tanggal'],
            'supplier_id' => $validated['supplier_id'],
            'no_po' => $validated['no_po'],
        ]);
        return redirect()->route('sheetgalvanize.index')->with('success', 'inspeksi galvanize berhasil disimpan');
    }



    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'tebal' => 'required',
            'coating' => 'required',
            'visual' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);


        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $insg = InspeksiSheetGalvanize::create([
            'sheet_galvanize_id' => $id,
            'user_id' => Auth::id(), // pastikan ada kolom ini
            'tebal' => $validated['tebal'],
            'coating' => $validated['coating'],
            'visual' => $validated['visual'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_sg', 'public');
            }
            $insg->update(['files' => $paths]);
        }

        return redirect()
            ->route('sheetgalvanize.show', $id)
            ->with('success', 'Data inspeksi sheet galvanized berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(SheetGalvanize $sheetgalvanize)
    {
        return view('sheetgalvanize.show', compact('sheetgalvanize'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
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
