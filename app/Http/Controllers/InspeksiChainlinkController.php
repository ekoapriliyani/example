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
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSCL{$tahunBulan}";

        // 2. Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = InspeksiChainlink::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSCL202606001

        // 4. Ambil data mesin dan PRO
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
            'nomor_inspeksi' => 'required|string|max:255', // Lepas unique rule di sini karena nomor di-generate ulang di backend agar aman
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

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data (Format Bulanan)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSCL{$tahunBulan}";

        $lastRecord = InspeksiChainlink::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // 2. Masukkan nomor yang sudah pasti aman dan sinkron ke array data
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;
        $validated['total_prod'] = $validated['total_prod'] ?? null;

        // 3. Simpan ke database menggunakan data yang sudah tervalidasi
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

        $inspeksiChainlink->update($request->all());

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
