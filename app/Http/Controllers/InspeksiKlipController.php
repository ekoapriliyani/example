<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKlip;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductRazor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiKlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiKlip::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_klip.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiKlip::where('nomor_inspeksi', 'like', "%INSK{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSK{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSK{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();
        $pros = Pro::orderByDesc('pro_id')->get();
        $productrazors = ProductRazor::orderBy('description', 'asc')->get();

        return view('inspeksi_klip.create', compact('nextNomor', 'pros', 'mesins', 'productrazors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_klips,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'mesin_id' => 'nullable|exists:mesins,id',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiKlip::where('nomor_inspeksi', 'like', "INSK{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSK{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSK{$tahunBulan}{$nextNumber}";

        InspeksiKlip::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'total_prod' => $validated['total_prod'] ?? null,
            'mesin_id' => $validated['mesin_id'] ?? null,
            'product_razor_ref_id' => $validated['product_razor_ref_id'] ?? null
        ]);

        return redirect()->route('inspeksi_klip.index')->with('success', 'Data inspeksi klip berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiKlip $inspeksi_klip)
    {
        $inspeksi_klip->load(['pro', 'mesin', 'inspeksiKlipWip']);
        return view('inspeksi_klip.show', ['inspeksi_klip' => $inspeksi_klip]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiKlip $inspeksi_klip)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();
        $productrazors = ProductRazor::orderBy('product_razor_id', 'asc')->get();

        return view('inspeksi_klip.edit', compact('inspeksi_klip', 'pros', 'mesins', 'productrazors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiKlip $inspeksi_klip)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_klips,nomor_inspeksi,' . $inspeksi_klip->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'mesin_id' => 'nullable|exists:mesins,id',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $inspeksi_klip->update($validated);

        return redirect()->route('inspeksi_klip.index')->with('success', 'Data inspeksi klip berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiKlip $inspeksi_klip)
    {
        $inspeksi_klip->delete();

        return redirect()->route('inspeksi_klip.index')->with('success', 'Data inspeksi klip berhasil dihapus.');
    }

    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiKlip::findOrFail($id);

        if ($inspeksi->isApproved()) {
            // UNAPPROVE
            $inspeksi->update([
                'approval_status' => 'PENDING',
                'approved_by' => null,
                'approved_at' => null,
            ]);

            $message = 'Approval dibatalkan.';
        } else {
            // APPROVE
            $inspeksi->update([
                'approval_status' => 'APPROVED',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $message = 'Data berhasil di-approve.';
        }

        return back()->with('success', $message);
    }
}
