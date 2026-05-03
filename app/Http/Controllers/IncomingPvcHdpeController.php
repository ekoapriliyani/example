<?php

namespace App\Http\Controllers;

use App\Models\IncomingPvcHdpe;
use App\Models\IncomingPvcHdpeInspeksi;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingPvcHdpeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IncomingPvcHdpe::all();
        return view('incomingpvchdpe.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = IncomingPvcHdpe::where('nomor_inspeksi', 'like', "INPVCHDPE{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INPVCHDPE{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INPVCHDPE{$tahunBulan}{$nextNumber}";
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('incomingpvchdpe.create', compact('nextNomor','suppliers'));
    }



    public function createInspeksi($id){
        $incomingpvchdpe = IncomingPvcHdpe::findOrFail($id);

        return view('incomingpvchdpe.inspeksi', compact('incomingpvchdpe'));
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
            'no_sj' => '',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = IncomingPvcHdpe::where('nomor_inspeksi', 'like', "INPVCHDPE{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (!$lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INPVCHDPE{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INPVCHDPE{$tahunBulan}{$nextNumber}";


        IncomingPvcHdpe::create([
            'tanggal' => $validated['tanggal'],
            'nomor_inspeksi' => $nomorOtomatis,
            'supplier_id' => $validated['supplier_id'],
            'no_po' => $validated['no_po'],
            'no_sj' => $validated['no_sj'],
        ]);
        return redirect()->route('incomingpvchdpe.index')->with('success', 'data incoming berhasil disimpan');
    }



    // store inspeksi
    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'visual'  => 'required|in:OK,NG',
            'certificate' => 'nullable|string',
            'files'   => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        $inpvchdpe = IncomingPvcHdpeInspeksi::create([
            'incoming_pvc_hdpe_id' => $id,
            'user_id' => Auth::id(),
            'visual' => $validated['visual'],
            'certificate' => $validated['certificate'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $paths[] = $file->storeAs(
                    'uploads/incomingpvchdpe',
                    $name,
                    'public'
                );
            }

            $inpvchdpe->update([
                'files' => $paths
            ]);
        }

        return redirect()
            ->route('incomingpvchdpe.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(IncomingPvcHdpe $incomingpvchdpe)
    {
        return view('incomingpvchdpe.show', compact('incomingpvchdpe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = IncomingPvcHdpe::findOrFail($id);
        $suppliers = Supplier::all();

        return view('incomingpvchdpe.edit', compact('data', 'suppliers'));
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
            'no_sj' => '',
        ]);

        $incomingPvcHdpe = IncomingPvcHdpe::findOrFail($id);
        $incomingPvcHdpe->update($validated);

        return redirect()->route('incomingpvchdpe.index')->with('success', 'Data incoming berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incomingPvcHdpe = IncomingPvcHdpe::findOrFail($id);
        $incomingPvcHdpe->delete();

        return redirect()->route('incomingpvchdpe.index')->with('success', 'Data incoming berhasil dihapus');
    }
}
