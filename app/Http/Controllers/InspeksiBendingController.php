<?php

namespace App\Http\Controllers;

use App\Models\InspeksiBending;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductFencing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiBendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiBending::with(['pro', 'mesin', 'productFencing'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_bending.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiBending::where('nomor_inspeksi', 'like', "INSBEN{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSBEN{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSBEN{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();
        $productFencings = ProductFencing::orderBy('product_fencing_id')->get();

        return view('inspeksi_bending.create', compact('nextNomor', 'pros', 'mesins', 'productFencings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_bendings,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'product_fencing_ref_id' => 'required|exists:product_fencings,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => '',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiBending::where('nomor_inspeksi', 'like', "INSBEN{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSBEN{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSBEN{$tahunBulan}{$nextNumber}";

        InspeksiBending::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'], // ini FK ke pros.id
            'product_fencing_ref_id' => $validated['product_fencing_ref_id'] ?? null,
            'shift' => $validated['shift'],
            'mesin_id' => $validated['mesin_id'] ?? null,
            'total_prod' => $validated['total_prod'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_bending.index')
            ->with('success', "Inspeksi {$nomorOtomatis} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiBending $inspeksi_bending)
    {
        $inspeksi_bending->load(['pro', 'mesin', 'productFencing', 'inspeksiBendingWip', 'inspeksiBendingFg']);

        return view('inspeksi_bending.show', ['inspeksi_bending' => $inspeksi_bending]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiBending $inspeksiBending)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $productFencings = ProductFencing::orderBy('product_fencing_id')->get();

        return view('inspeksi_bending.edit', compact('inspeksiBending', 'pros', 'mesins', 'productFencings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => "required|unique:inspeksi_bendings,nomor_inspeksi,{$id}",
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'product_fencing_ref_id' => 'required|exists:product_fencings,id',
            'shift' => 'required',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => '',
        ]);

        $inspeksiBending = InspeksiBending::findOrFail($id);
        $inspeksiBending->update($validated);

        return redirect()
            ->route('inspeksi_bending.index')
            ->with('success', "Inspeksi {$validated['nomor_inspeksi']} berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiBending $inspeksiBending)
    {
        $inspeksiBending->delete();
        return redirect()
            ->route('inspeksi_bending.index')
            ->with('success', "Inspeksi {$inspeksiBending->nomor_inspeksi} berhasil dihapus");
    }

    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiBending::findOrFail($id);

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
