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
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSK{$tahunBulan}";

        // 2. Cari nomor terakhir yang memiliki prefix serupa di bulan ini
        $lastRecord = InspeksiKlip::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            // Ambil string nomor aslinya, buang prefix-nya
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        // 3. Gunakan str_pad agar nomor urut konsisten memiliki panjang 3 digit (001, 002, dst)
        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSK202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_klip.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required', // validasi unique dilepas disini karena nomor di-generate ulang di backend agar aman
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'total_prod' => '',
            'satuan' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        // LAKUKAN PENGECEKAN ULANG SAAT SAVE AGAR MENGHINDARI DUPLIKAT JIKA ADA 2 USER INPUT BERSAMAAN
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSK{$tahunBulan}";

        $lastRecord = InspeksiKlip::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // Masukkan nomor yang sudah pasti aman dan sinkron
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;

        // Simpan ke database
        InspeksiKlip::create($validated);

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
            'satuan' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
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
