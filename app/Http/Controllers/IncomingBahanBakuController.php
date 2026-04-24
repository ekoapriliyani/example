<?php

namespace App\Http\Controllers;

use App\Models\IncomingBahanBaku;
use App\Models\IncomingBahanBakuInspeksi;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingBahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IncomingBahanBaku::all();
        return view('incomingbahanbaku.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = IncomingBahanBaku::where('nomor_inspeksi', 'like', "INBB{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INBB{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INBB{$tahunBulan}{$nextNumber}";
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('incomingbahanbaku.create', compact('nextNomor','suppliers'));
    }

    public function inspeksi()
    {
        return view('incomingbahanbaku.inspeksi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
            'no_sj' => 'required',
            'jml_koil' => 'required',
            'd_kawat' => 'required',
            'tol' => 'required',
            'jenis_kawat' => 'required',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = IncomingBahanBaku::where('nomor_inspeksi', 'like', "INBB{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (!$lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INBB{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INBB{$tahunBulan}{$nextNumber}";


        IncomingBahanBaku::create([
            'tanggal' => $validated['tanggal'],
            'nomor_inspeksi' => $nomorOtomatis,
            'supplier_id' => $validated['supplier_id'],
            'no_po' => $validated['no_po'],
            'no_sj' => $validated['no_sj'],
            'jml_koil' => $validated['jml_koil'],
            'd_kawat' => $validated['d_kawat'],
            'tol' => $validated['tol'],
            'jenis_kawat' => $validated['jenis_kawat'],
        ]);
        return redirect()->route('incomingbahanbaku.index')->with('success', 'data incoming berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingBahanBaku $incomingbahanbaku)
    {
        return view('incomingbahanbaku.show', compact('incomingbahanbaku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = IncomingBahanBaku::findOrFail($id);
        $suppliers = Supplier::all();

        return view('incomingbahanbaku.edit', compact('data', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'tanggal' => 'required',
        'supplier_id' => 'required',
        'no_po' => 'required',
        'no_sj' => 'required',
        'jml_koil' => 'required',
        'd_kawat' => 'required',
        'tol' => 'required',
        'jenis_kawat' => 'required',
        ]);

        $item = IncomingBahanBaku::findOrFail($id);

        $item->update($validated);

        return redirect()->route('incomingbahanbaku.index')
            ->with('success', 'Data berhasil diupdate');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createInspeksi($id)
    {
        $incomingbahanbaku = IncomingBahanBaku::findOrFail($id);

        return view('incomingbahanbaku.inspeksi_create', compact('incomingbahanbaku'));
    }

    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'no_koil' => 'required',
            'd1' => 'nullable|numeric',
            'd2' => 'nullable|numeric',
            'd3' => 'nullable|numeric',
            'dimensi' => 'nullable|string',
            'visual' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // hitung rata-rata
        $rata_rata = collect([
            $validated['d1'],
            $validated['d2'],
            $validated['d3']
        ])->filter()->avg();

        IncomingBahanBakuInspeksi::create([
            'incoming_bahan_baku_id' => $id,
            'user_id' => Auth::id(), // pastikan ada kolom ini
            'no_koil' => $validated['no_koil'],
            'd1' => $validated['d1'],
            'd2' => $validated['d2'],
            'd3' => $validated['d3'],
            'rata_rata' => $rata_rata,
            'dimensi' => $validated['dimensi'],
            'visual' => $validated['visual'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()
            ->route('incomingbahanbaku.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
    }
}
