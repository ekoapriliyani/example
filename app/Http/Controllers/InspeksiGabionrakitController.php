<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionrakit;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiGabionrakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = InspeksiGabionrakit::with(['pro', 'mesin'])
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_gabionrakit.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSRA{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang benar-benar masuk database
        $lastRecord = InspeksiGabionrakit::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INSRA202606001

        // 4. Ambil data mesin dan PRO
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_gabionrakit.create', compact('nextNomor', 'pros', 'mesins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_inspeksi' => 'required|string|max:255|unique:inspeksi_gabionrakits,nomor_inspeksi',
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'diameter' => '',
            'ukuran' => '',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $today = now()->format('Ymd');
        $lastInspeksi = \App\Models\InspeksiGabionrakit::whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInspeksi) {
            // Ambil 3 digit terakhir dari nomor_inspeksi terakhir, lalu tambahkan 1
            $lastNumber = (int) substr($lastInspeksi->nomor_inspeksi, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $fixNomorInspeksi = "INSRA" . $today . $nextNumber;

        // 3. Masukkan nomor yang sudah pasti aman dan unik ke dalam array data validasi
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;

        // 4. Simpan ke database
        InspeksiGabionrakit::create($validated);

        return redirect()->route('inspeksi_gabionrakit.index')->with('success', 'Data inspeksi gabionrakit berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiGabionrakit $inspeksiGabionrakit)
    {
        $inspeksiGabionrakit->load(['pro', 'mesin', 'inspeksiGabionrakitWip']);
        return view('inspeksi_gabionrakit.show', compact('inspeksiGabionrakit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiGabionrakit $inspeksiGabionrakit)
    {
        return view('inspeksi_gabionrakit.edit', [
            'inspeksiGabionrakit' => $inspeksiGabionrakit,
            'pros' => Pro::orderByDesc('pro_id')->get(),
            'mesins' => Mesin::orderBy('mesin_id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiGabionrakit $inspeksiGabionrakit)
    {
        $request->validate([
            'nomor_inspeksi' => 'required|unique:inspeksi_gabionrakits,nomor_inspeksi,' . $inspeksiGabionrakit->id,
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required|string|max:255',
            'diameter' => 'nullable|numeric',
            'ukuran' => 'nullable',
            'mesin_id' => 'required|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required|string',
        ]);

        $inspeksiGabionrakit->update($request->all());

        return redirect()->route('inspeksi_gabionrakit.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiGabionrakit $inspeksiGabionrakit)
    {
        $inspeksiGabionrakit->delete();
        return redirect()->route('inspeksi_gabionrakit.index')->with('success', 'Data inspeksi gabionrakit berhasil dihapus.');
    }


    // approval
    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = InspeksiGabionrakit::findOrFail($id);

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
