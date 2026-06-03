<?php

namespace App\Http\Controllers;

use App\Models\InspeksiChainlink;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiChainlinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiChainlink::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_chainlink.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = InspeksiChainlink::where('nomor_inspeksi', 'like', "INSCL{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INSCL{$tahunBulan}", '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INSCL{$tahunBulan}{$nextNumber}";

        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_chainlink.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|string|max:255|unique:inspeksi_chainlinks,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'mesin_id' => 'required|exists:mesins,id',
            'jml_lubang_p' => 'required|numeric',
            'jml_counter' => 'required|numeric',
            'jml_lubang_l' => 'required|numeric',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        InspeksiChainlink::create($validated);
        return redirect()->route('inspeksi_chainlink.index')->with('success', 'Data inspeksi chainlink berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiChainlink $inspeksiChainlink)
    {
        $inspeksiChainlink->load(['pro', 'mesin', 'inspeksiChainlinkWip', 'inspeksiChainlinkFg']);
        return view('inspeksi_chainlink.show', compact('inspeksiChainlink'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiChainlink $inspeksiChainlink)
    {
        return view('inspeksi_chainlink.edit', [
            'inspeksiChainlink' => $inspeksiChainlink,
            'pros' => Pro::orderByDesc('pro_id')->get(),
            'mesins' => Mesin::orderBy('mesin_id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiChainlink $inspeksiChainlink)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_chainlinks,nomor_inspeksi,' . $inspeksiChainlink->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'mesin_id' => 'required|exists:mesins,id',
            'jml_lubang_p' => 'required|numeric',
            'jml_counter' => 'required|numeric',
            'jml_lubang_l' => 'required|numeric',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $today = now()->format('Ymd');
        $lastInspeksi = \App\Models\InspeksiChainlink::whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInspeksi) {
            // Ambil 3 digit terakhir dari nomor_inspeksi terakhir, lalu tambahkan 1
            $lastNumber = (int) substr($lastInspeksi->nomor_inspeksi, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $fixNomorInspeksi = "INSP-CL-" . $today . "-" . $nextNumber;

        // 3. Masukkan nomor yang sudah pasti aman dan unik ke dalam array data validasi
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;

        // 4. Simpan ke database
        InspeksiChainlink::create($validated);

        return redirect()->route('inspeksi_chainlink.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiChainlink $inspeksiChainlink)
    {
        $inspeksiChainlink->delete();
        return redirect()->route('inspeksi_chainlink.index')->with('success', 'Data inspeksi chainlink berhasil dihapus.');
    }

    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiChainlink::findOrFail($id);

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
