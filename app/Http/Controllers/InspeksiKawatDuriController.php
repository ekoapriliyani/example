<?php

namespace App\Http\Controllers;

use App\Models\InspeksiKawatDuri;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiKawatDuriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiKawatDuri::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_kawat_duri.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiKawatDuri::where('nomor_inspeksi', 'like', "INSKD{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSKD{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSKD{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderBy('pro_id')->get();

        return view('inspeksi_kawat_duri.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_kawat_duris,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string',
            'mesin_id' => 'nullable|exists:mesins,id',
            'type_coating' => 'required|string',
            'total_prod' => 'nullable|numeric',
        ]);

        InspeksiKawatDuri::create($request->all());

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $inspeksiKawatDuri->load(['pro', 'mesin', 'inspeksiKawatDuriWip', 'inspeksiKawatDuriFg']);
        return view('inspeksi_kawat_duri.show', compact('inspeksiKawatDuri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inspeksiKawatDuri = InspeksiKawatDuri::findOrFail($id);
        $pros = Pro::orderBy('pro_id')->get();
        $mesins = Mesin::orderBy('mesin_id')->get();

        return view('inspeksi_kawat_duri.edit', compact(
            'inspeksiKawatDuri',
            'pros',
            'mesins'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_kawat_duris,nomor_inspeksi,' . $inspeksiKawatDuri->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string',
            'mesin_id' => 'nullable|exists:mesins,id',
            'type_coating' => 'required|string',
            'total_prod' => 'nullable|numeric',
        ]);

        $inspeksiKawatDuri->update($request->all());

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiKawatDuri $inspeksiKawatDuri)
    {
        $inspeksiKawatDuri->delete();

        return redirect()->route('inspeksi_kawat_duri.index')->with('success', 'Data berhasil dihapus.');
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiKawatDuri::findOrFail($id);

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
