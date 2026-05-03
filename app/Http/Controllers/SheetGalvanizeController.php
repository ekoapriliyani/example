<?php

namespace App\Http\Controllers;

use App\Models\InspeksiSheetGalvanize;
use App\Models\SheetGalvanize;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'tebal'   => 'required',
            'coating' => 'required',
            'visual'  => 'required|in:OK,NG',
            'files'   => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        $insg = InspeksiSheetGalvanize::create([
            'sheet_galvanize_id' => $id,
            'user_id' => Auth::id(),
            'tebal' => $validated['tebal'],
            'coating' => $validated['coating'],
            'visual' => $validated['visual'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $paths[] = $file->storeAs(
                    'uploads/inspeksi_sg',
                    $name,
                    'public'
                );
            }

            $insg->update([
                'files' => $paths
            ]);
        }

        return redirect()
            ->route('sheetgalvanize.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
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
    public function edit($id)
    {
        $sheetgalvanize = SheetGalvanize::findOrFail($id);
        $suppliers = Supplier::all();

        return view('sheetgalvanize.edit', compact('sheetgalvanize', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required',
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
        ]);

        $item = SheetGalvanize::findOrFail($id);

        $item->update($validated);

        return redirect()->route('sheetgalvanize.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function destroyInspeksi($id)
    {
        $inspeksi = InspeksiSheetGalvanize::findOrFail($id);

        $sheetGalvanizeId = $inspeksi->sheet_galvanize_id;

        if ($inspeksi->files) {
            foreach ($inspeksi->files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $inspeksi->delete();

        return redirect()
            ->route('sheetgalvanize.show', $sheetGalvanizeId)
            ->with('success', 'Data inspeksi berhasil dihapus.');
    }
}
