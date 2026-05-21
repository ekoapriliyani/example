<?php

namespace App\Http\Controllers;

use App\Models\InspeksiRazorpacking;
use App\Models\Pro;
use App\Models\ProductRazor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiRazorpackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiRazorpacking::with(['pro'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_razorpacking.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiRazorpacking::where('nomor_inspeksi', 'like', "%INSRP{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSRP{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSRP{$tahunBulan}{$nextNumber}";
        $pros = Pro::orderByDesc('pro_id')->get();
        $productrazors = ProductRazor::orderBy('description', 'asc')->get();

        return view('inspeksi_razorpacking.create', compact('nextNomor', 'pros', 'productrazors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_razorpackings,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiRazorpacking::where('nomor_inspeksi', 'like', "INSRP{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSRP{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSRP{$tahunBulan}{$nextNumber}";

        InspeksiRazorpacking::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'total_prod' => $validated['total_prod'] ?? null,
            'product_razor_ref_id' => $validated['product_razor_ref_id'] ?? null
        ]);

        return redirect()->route('inspeksi_razorpacking.index')->with('success', 'Data inspeksi razor packing berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiRazorpacking $inspeksi_razorpacking)
    {
        $inspeksi_razorpacking->load(['pro']);
        return view('inspeksi_razorpacking.show', ['inspeksiRazorpacking' => $inspeksi_razorpacking]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiRazorpacking $inspeksi_razorpacking)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $productrazors = ProductRazor::orderBy('description', 'asc')->get();

        return view('inspeksi_razorpacking.edit', compact('inspeksi_razorpacking', 'pros', 'productrazors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'product_razor_ref_id' => 'nullable|exists:product_razors,id'
        ]);

        $inspeksi_razorpacking = InspeksiRazorpacking::findOrFail($id);
        $inspeksi_razorpacking->update([
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'total_prod' => $validated['total_prod'] ?? null,
            'product_razor_ref_id' => $validated['product_razor_ref_id'] ?? null
        ]);

        return redirect()->route('inspeksi_razorpacking.index')->with('success', 'Data inspeksi razor packing berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiRazorpacking $inspeksi_razorpacking)
    {
        $inspeksi_razorpacking->delete();
        return redirect()->route('inspeksi_razorpacking.index')->with('success', 'Data inspeksi razor packing berhasil dihapus.');
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiRazorpacking::findOrFail($id);

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
