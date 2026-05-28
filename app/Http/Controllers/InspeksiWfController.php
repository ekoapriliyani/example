<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWf;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiWfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiWf::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_wf.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiWf::where('nomor_inspeksi', 'like', "INSWF{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSWF{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSWF{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_wf.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = InspeksiWf::where('nomor_inspeksi', 'like', "INSWF{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (! $lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INSWF{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INSWF{$tahunBulan}{$nextNumber}";

        InspeksiWf::create([
            'nomor_inspeksi' => $nomorOtomatis,
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'mesin_id' => $validated['mesin_id'] ?? null,
            'total_prod' => $validated['total_prod'] ?? null,
            'satuan' => $validated['satuan'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_wf.index')
            ->with('success', "Inspeksi {$nomorOtomatis} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiWf $inspeksi_wf)
    {
        $inspeksi_wf->load(['pro', 'mesin', 'inspeksiWfWip']);

        return view('inspeksi_wf.show', ['inspeksi_wf' => $inspeksi_wf]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWf $inspeksi_wf)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();

        return view('inspeksi_wf.edit', compact('inspeksi_wf', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWf $inspeksi_wf)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        $inspeksi_wf->update([
            'tanggal' => $validated['tanggal'],
            'pro_id' => $validated['pro_id'],
            'shift' => $validated['shift'],
            'mesin_id' => $validated['mesin_id'] ?? null,
            'total_prod' => $validated['total_prod'] ?? null,
            'satuan' => $validated['satuan'] ?? null,
        ]);

        return redirect()
            ->route('inspeksi_wf.index')
            ->with('success', 'Data inspeksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses hapus.');
        }

        $data = InspeksiWf::findOrFail($id);

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

        $inspeksi = InspeksiWf::findOrFail($id);

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
