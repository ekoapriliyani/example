<?php

namespace App\Http\Controllers;

use App\Models\InspeksiPound;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductRazor;

class InspeksiPoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiPound::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_pound.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiPound::where('nomor_inspeksi', 'like', "%INSP{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSP{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSP{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();
        $pros = Pro::orderByDesc('pro_id')->get();
        $productrazors = ProductRazor::orderBy('description', 'asc')->get();

        return view('inspeksi_pound.create', compact('nextNomor', 'pros', 'mesins', 'productrazors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_pounds,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'mesin_id' => 'nullable|exists:mesins,id',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiPound::where('nomor_inspeksi', 'like', "INSP{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSP{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSP{$tahunBulan}{$nextNumber}";

        InspeksiPound::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'total_prod' => $validated['total_prod'] ?? null,
            'mesin_id' => $validated['mesin_id'] ?? null,
            'product_razor_ref_id' => $validated['product_razor_ref_id'] ?? null
        ]);

        return redirect()->route('inspeksi_pound.index')->with('success', 'Data inspeksi pound berhasil disimpan.');
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
    public function edit(InspeksiPound $inspeksi_pound)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();
        $productrazors = ProductRazor::orderBy('product_razor_id', 'asc')->get();

        return view('inspeksi_pound.edit', compact('inspeksi_pound', 'pros', 'mesins', 'productrazors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiPound $inspeksi_pound)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_pounds,nomor_inspeksi,' . $inspeksi_pound->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'mesin_id' => 'nullable|exists:mesins,id',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $inspeksi_pound->update($validated);

        return redirect()->route('inspeksi_pound.index')->with('success', 'Data inspeksi pound berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses hapus.');
        }

        $data = InspeksiPound::findOrFail($id);

        if ($data->isApproved()) {
            return back()->with('error', 'Data sudah di-approve, tidak bisa dihapus.');
        }

        $data->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiPound::findOrFail($id);

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
