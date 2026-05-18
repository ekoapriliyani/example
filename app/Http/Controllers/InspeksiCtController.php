<?php

namespace App\Http\Controllers;

use App\Models\InspeksiCt;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductCt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiCtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiCt::with(['pro', 'mesin', 'productCt'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_ct.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiCt::where('nomor_inspeksi', 'like', "INSCT{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSCT{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSCT{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();
        $productCts = ProductCt::orderBy('product_ct_id')->get();

        return view('inspeksi_ct.create', compact('nextNomor', 'pros', 'mesins', 'productCts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_cts,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'product_ct_ref_id' => 'required|exists:product_cts,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
        ]);

        InspeksiCt::create($validated);

        return redirect()->route('inspeksi_ct.index')->with('success', 'Data inspeksi CTCL berhasil ditambahkan');
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
    public function edit(InspeksiCt $inspeksi_ct)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $productCts = ProductCt::orderBy('product_ct_id')->get();

        return view('inspeksi_ct.edit', compact('inspeksi_ct', 'pros', 'mesins', 'productCts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiCt $inspeksi_ct)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'product_ct_ref_id' => 'required|exists:product_cts,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
        ]);

        $inspeksi_ct->update($validated);

        return redirect()->route('inspeksi_ct.index')->with('success', "Data inspeksi {$inspeksi_ct->nomor_inspeksi} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiCt $inspeksi_ct)
    {
        $inspeksi_ct->delete();
        return redirect()->route('inspeksi_ct.index')->with('success', "Data inspeksi {$inspeksi_ct->nomor_inspeksi} berhasil dihapus");
    }
}
