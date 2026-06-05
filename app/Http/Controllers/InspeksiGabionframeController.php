<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionframe;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiGabionframeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = InspeksiGabionframe::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_gabionframe.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSFR{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang benar-benar masuk database
        $lastRecord = InspeksiGabionframe::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            // Ambil string nomor aslinya, buang prefix-nya
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        // 3. PERBAIKAN: Gunakan str_pad agar nomor urut konsisten memiliki panjang 3 digit (001, 002, dst)
        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSFR202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_gabionframe.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|string|max:255|unique:inspeksi_gabionframes,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $today = now()->format('Ymd');
        $lastInspeksi = \App\Models\InspeksiGabionframe::whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInspeksi) {
            // Ambil 3 digit terakhir dari nomor_inspeksi terakhir, lalu tambahkan 1
            $lastNumber = (int) substr($lastInspeksi->nomor_inspeksi, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $fixNomorInspeksi = "INSFR" . $today . $nextNumber;

        // 3. Masukkan nomor yang sudah pasti aman dan unik ke dalam array data validasi
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;

        // 4. Simpan ke database
        InspeksiGabionframe::create($validated);

        return redirect()->route('inspeksi_gabionframe.index')->with('success', 'Data inspeksi gabionframe berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiGabionframe $inspeksiGabionframe)
    {
        $inspeksiGabionframe->load(['pro', 'mesin', 'inspeksiGabionframeWip']);
        return view('inspeksi_gabionframe.show', compact('inspeksiGabionframe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiGabionframe $inspeksiGabionframe)
    {
        return view('inspeksi_gabionframe.edit', [
            'inspeksiGabionframe' => $inspeksiGabionframe,
            'pros' => Pro::orderByDesc('pro_id')->get(),
            'mesins' => Mesin::orderBy('mesin_id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiGabionframe $inspeksiGabionframe)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_gabionframes,nomor_inspeksi,' . $inspeksiGabionframe->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $inspeksiGabionframe->update($request->all());

        return redirect()->route('inspeksi_gabionframe.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiGabionframe $inspeksiGabionframe)
    {
        $inspeksiGabionframe->delete();

        return redirect()->route('inspeksi_gabionframe.index')->with('success', 'Data inspeksi gabionframe berhasil dihapus.');
    }

    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiGabionframe::findOrFail($id);

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
