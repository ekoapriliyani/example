<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductWm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiWm::with(['pro', 'mesin', 'productWm'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_wm.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "INSWM{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSWM{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSWM{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderBy('pro_id')->get();
        $productWms = ProductWm::orderBy('product_wm_id')->get();

        return view('inspeksi_wm.create', compact('nextNomor', 'pros', 'mesins', 'productWms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pro_id' => 'required|exists:pros,id',
            'product_wm_ref_id' => 'nullable|exists:product_wms,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "INSWM{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSWM{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSWM{$tahunBulan}{$nextNumber}";

        InspeksiWm::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'pro_id' => $validated['pro_id'], // ini FK ke pros.id
            'product_wm_ref_id' => $validated['product_wm_ref_id'] ?? null,
            'shift' => $validated['shift'],
            'grade' => $validated['grade'],
            'type_coating' => $validated['type_coating'],
            'mesin_id' => $validated['mesin_id'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', "Inspeksi {$nomorOtomatis} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiWm $inspeksi_wm)
    {
        $inspeksi_wm->load(['pro', 'mesin', 'productWm', 'inspeksiWmWip', 'inspeksiWmFg']);

        return view('inspeksi_wm.show', ['inspeksi_wm' => $inspeksi_wm]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWm $inspeksi_wm)
    {
        $pros = Pro::orderBy('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $productWms = ProductWm::orderBy('product_wm_id')->get();

        return view('inspeksi_wm.edit', compact('inspeksi_wm', 'pros', 'mesins', 'productWms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWm $inspeksi_wm)
    {
        $validated = $request->validate([
            'pro_id' => 'required|exists:pros,id',
            'product_wm_ref_id' => 'nullable|exists:product_wms,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'shear_strength' => 'nullable|numeric',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        $inspeksi_wm->update([
            'pro_id' => $validated['pro_id'],
            'product_wm_ref_id' => $validated['product_wm_ref_id'] ?? null,
            'shift' => $validated['shift'],
            'grade' => $validated['grade'],
            'type_coating' => $validated['type_coating'],
            'shear_strength' => $validated['shear_strength'] ?? null,
            'mesin_id' => $validated['mesin_id'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', 'Data inspeksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiWm $inspeksiWm)
    {
        $inspeksiWm->delete();

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', 'Inspeksi berhasil dihapus');
    }

    /**
     * Get PRO detail for AJAX.
     */
    public function getProDetail($id)
    {
        $pro = Pro::find($id);

        if (! $pro) {
            return response()->json([
                'message' => 'PRO tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'id' => $pro->id,
            'pro_id' => $pro->pro_id, // kode PRO dari Sybase
            'description' => $pro->description,
            'qty' => $pro->qty,
        ]);
    }
}
