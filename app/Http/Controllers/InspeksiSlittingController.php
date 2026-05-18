<?php

namespace App\Http\Controllers;

use App\Models\InspeksiSlitting;
use App\Models\Mesin;
use App\Models\Pro;
use App\Models\ProductRazor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiSlittingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiSlitting::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_slitting.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiSlitting::where('nomor_inspeksi', 'like', "%INSS{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSS{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSS{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_slitting.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_slittings,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'mesin_id' => 'nullable|exists:mesins,id',
            'ukuran' => 'nullable|integer|min:0'
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiSlitting::where('nomor_inspeksi', 'like', "INSS{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSS{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSS{$tahunBulan}{$nextNumber}";

        InspeksiSlitting::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'total_prod' => $validated['total_prod'] ?? null,
            'mesin_id' => $validated['mesin_id'] ?? null,
            'ukuran' => $validated['ukuran'] ?? null
        ]);

        return redirect()->route('inspeksi_slitting.index')->with('success', 'Data inspeksi slitting berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiSlitting $inspeksi_slitting)
    {
        $inspeksi_slitting->load(['pro', 'mesin', 'inspeksiSlittingWip']);
        return view('inspeksi_slitting.show', ['inspeksi_slitting' => $inspeksi_slitting]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiSlitting $inspeksi_slitting)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin', 'asc')->get();

        return view('inspeksi_slitting.edit', compact('inspeksi_slitting', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InspeksiSlitting $inspeksi_slitting, Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => 'nullable|numeric|min:0',
            'mesin_id' => 'nullable|exists:mesins,id',
            'ukuran' => 'nullable|integer|min:0'
        ]);

        $inspeksi_slitting->update($validated);

        return redirect()->route('inspeksi_slitting.index')->with('success', 'Data inspeksi slitting berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses hapus.');
        }

        $data = InspeksiSlitting::findOrFail($id);

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

        $inspeksi = InspeksiSlitting::findOrFail($id);

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
