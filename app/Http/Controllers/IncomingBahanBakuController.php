<?php

namespace App\Http\Controllers;

use App\Models\IncomingBahanBaku;
use App\Models\IncomingBahanBakuInspeksi;
use App\Models\MechanicalTest;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncomingBahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = IncomingBahanBaku::with('supplier') // Eager loading relasi supplier
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('no_po', 'like', "%{$search}%")
                    // Jika ingin mencari berdasarkan nama supplier yang berelasi
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc') // Lebih aman menggunakan parameter waktu pembuatan data
            ->paginate(10)
            ->withQueryString();

        return view('incomingbahanbaku.index', compact('data'));
    }



    public function inspeksi()
    {
        return view('incomingbahanbaku.inspeksi');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INBB{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = IncomingBahanBaku::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: INBB202606001

        // 4. Ambil data Supplier
        $suppliers = Supplier::orderBy('supplier_code')->get();

        return view('incomingbahanbaku.create', compact('nextNomor', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
            'no_sj' => 'required',
            'jml_koil' => 'required',
            'd_kawat' => 'required',
            'tol' => 'required',
            'jenis_kawat' => 'required',
            'certificate' => 'nullable',
            'files' => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INBB{$tahunBulan}";

        $lastRecord = IncomingBahanBaku::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // 2. Masukkan nomor yang sudah pasti aman dan sinkron ke array data sebelum di-create
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;
        $validated['certificate'] = $validated['certificate'] ?? null;

        // 3. Simpan data utama ke database
        $inc = IncomingBahanBaku::create($validated);

        // 4. Proses upload file jika ada
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paths[] = $file->storeAs(
                    'uploads/incomingbahanbaku',
                    $name,
                    'public'
                );
            }
            $inc->update([
                'files' => $paths
            ]);
        }

        return redirect()->route('incomingbahanbaku.index')->with('success', "Data incoming {$fixNomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingBahanBaku $incomingbahanbaku)
    {
        $incomingbahanbaku->load('mechanicalTests');

        return view('incomingbahanbaku.show', compact('incomingbahanbaku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = IncomingBahanBaku::findOrFail($id);
        $suppliers = Supplier::all();

        return view('incomingbahanbaku.edit', compact('data', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'no_po' => 'required',
            'no_sj' => 'required',
            'jml_koil' => 'required',
            'd_kawat' => 'required',
            'tol' => 'required',
            'jenis_kawat' => 'required',

            'files.*' => 'nullable|file|max:5120',
        ]);

        $item = IncomingBahanBaku::findOrFail($id);

        // update data utama
        $item->update($validated);

        /*
    |--------------------------------------------------------------------------
    | Replace File Lama Dengan File Baru
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('files')) {

            // hapus file lama
            if (!empty($item->files)) {
                foreach ($item->files as $oldFile) {

                    if (is_array($oldFile)) {
                        foreach ($oldFile as $filePath) {
                            if (is_string($filePath) && Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                            }
                        }
                    } else {
                        if (is_string($oldFile) && Storage::disk('public')->exists($oldFile)) {
                            Storage::disk('public')->delete($oldFile);
                        }
                    }
                }
            }
            // upload file baru
            $paths = [];
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paths[] = $file->storeAs(
                    'uploads/incomingbahanbaku',
                    $name,
                    'public'
                );
            }
            $item->update([
                'files' => $paths,
            ]);
        }
        return redirect()
            ->route('incomingbahanbaku.index')
            ->with('success', 'Data berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = IncomingBahanBaku::findOrFail($id);

        // hapus file dari storage
        if (!empty($item->files)) {
            foreach ($item->files as $filePath) {
                if (is_string($filePath) && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
        // hapus data
        $item->delete();

        return redirect()
            ->route('incomingbahanbaku.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function createInspeksi($id)
    {
        $incomingbahanbaku = IncomingBahanBaku::findOrFail($id);

        return view('incomingbahanbaku.inspeksi_create', compact('incomingbahanbaku'));
    }

    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'no_koil' => 'required',
            'd1' => 'nullable|numeric',
            'd2' => 'nullable|numeric',
            'd3' => 'nullable|numeric',
            'dimensi' => 'nullable|string',
            'visual' => 'nullable|string',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            // 'keterangan' => 'nullable|string',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // hitung rata-rata
        $rata_rata = collect([
            $validated['d1'],
            $validated['d2'],
            $validated['d3']
        ])->filter()->avg();

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $insbb = IncomingBahanBakuInspeksi::create([
            'incoming_bahan_baku_id' => $id,
            'user_id' => Auth::id(), // pastikan ada kolom ini
            'no_koil' => $validated['no_koil'],
            'd1' => $validated['d1'],
            'd2' => $validated['d2'],
            'd3' => $validated['d3'],
            'rata_rata' => $rata_rata,
            'dimensi' => $validated['dimensi'],
            'visual' => $validated['visual'],
            'description1' => $validated['description1'],
            'description2' => $validated['description2'],
            // 'keterangan' => $validated['keterangan'],
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_bb', 'public');
            }
            $insbb->update(['files' => $paths]);
        }

        return redirect()
            ->route('incomingbahanbaku.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
    }

    public function editInspeksi(
        IncomingBahanBaku $incomingbahanbaku,
        IncomingBahanBakuInspeksi $inspeksi
    ) {
        return view(
            'incomingbahanbaku.inspeksi.edit',
            compact('incomingbahanbaku', 'inspeksi')
        );
    }

    public function updateInspeksi(
        Request $request,
        IncomingBahanBaku $incomingbahanbaku,
        IncomingBahanBakuInspeksi $inspeksi
    ) {
        $validated = $request->validate([
            'no_koil' => 'required',
            'd1' => 'required|numeric',
            'd2' => 'required|numeric',
            'd3' => 'required|numeric',
            'dimensi' => 'required',
            'visual' => 'required',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            'keterangan' => 'nullable',
            'files.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['rata_rata'] = (
            $validated['d1'] +
            $validated['d2'] +
            $validated['d3']
        ) / 3;

        if ($request->hasFile('files')) {
            // hapus file lama
            if ($inspeksi->files) {
                foreach ($inspeksi->files as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store(
                    'incoming_bahan_baku_inspeksi',
                    'public'
                );
                $uploadedFiles[] = $path;
            }
            $validated['files'] = $uploadedFiles;
        }

        $inspeksi->update($validated);

        return redirect()
            ->route('incomingbahanbaku.show', $incomingbahanbaku->id)
            ->with('success', 'Data inspeksi berhasil diupdate');
    }


    public function destroyInspeksi(IncomingBahanBakuInspeksi $inspeksi)
    {
        $incomingId = $inspeksi->incoming_bahan_baku_id;

        $inspeksi->delete();

        return redirect()
            ->route('incomingbahanbaku.show', $incomingId)
            ->with('success', 'Data inspeksi berhasil dihapus');
    }



    public function createMechanicalTest($id)
    {
        $incomingbahanbaku = IncomingBahanBaku::findOrFail($id);

        return view('incomingbahanbaku.mechanical_test_create', compact('incomingbahanbaku'));
    }

    public function storeMechanicalTest(Request $request, $id)
    {
        $validated = $request->validate([
            'nomor_koil' => 'required',
            'hasil_tensile' => 'required',
            'hasil_coatingweight' => 'required',
            'hasil_lilit' => 'required',
            'hasil_puntir' => 'required',
            'status' => 'required',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $mechanicalTest = MechanicalTest::create([
            'incoming_bahan_baku_id' => $id,
            'user_id' => Auth::id(),
            'nomor_koil' => $validated['nomor_koil'],
            'hasil_tensile' => $validated['hasil_tensile'],
            'hasil_coatingweight' => $validated['hasil_coatingweight'],
            'hasil_lilit' => $validated['hasil_lilit'],
            'hasil_puntir' => $validated['hasil_puntir'],
            'status' => $validated['status'],
            'description1' => $validated['description1'],
            'description2' => $validated['description2'],
            'files' => $validated['files'] ?? null,
        ]);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_bb', 'public');
            }
            $mechanicalTest->update(['files' => $paths]);
        }

        return redirect()
            ->route('incomingbahanbaku.show', $id)
            ->with('success', 'Data mechanical test berhasil ditambahkan');
    }

    public function editMechanicalTest(MechanicalTest $mechanicalTest)
    {
        return view('incomingbahanbaku.mechanicaltest.edit', compact('mechanicalTest'));
    }

    public function updateMechanicalTest(Request $request, MechanicalTest $mechanicalTest)
    {
        $validated = $request->validate([
            'nomor_koil' => 'required',
            'hasil_tensile' => 'required',
            'hasil_coatingweight' => 'required',
            'hasil_lilit' => 'required',
            'hasil_puntir' => 'required',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            'files.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required',
        ]);

        // 1. Ambil data files lama sebagai backup default
        $arrFiles = $mechanicalTest->files ?? [];

        // 2. Cek apakah user mengupload file/gambar baru
        if ($request->hasFile('files')) {

            // Hapus file fisik lama di storage jika ada
            if (!empty($mechanicalTest->files)) {
                foreach ($mechanicalTest->files as $oldFile) {

                    // PROTEKSI: Jika ternyata $oldFile adalah array, ambil index pertamanya [0]
                    $actualPath = is_array($oldFile) ? ($oldFile[0] ?? '') : $oldFile;

                    // Pastikan variabel berbentuk string dan tidak kosong sebelum di-cek ke Flysystem
                    if (!empty($actualPath) && is_string($actualPath)) {
                        if (Storage::disk('public')->exists($actualPath)) {
                            Storage::disk('public')->delete($actualPath);
                        }
                    }
                }
            }

            // Simpan file-file baru yang di-upload
            $arrFiles = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('mechanical_tests', 'public');
                $arrFiles[] = $path;
            }
        }

        // 3. Gabungkan array files baru ke dalam array validasi data update
        $validated['files'] = $arrFiles;

        // 4. Jalankan perintah update massal ke database
        $mechanicalTest->update($validated);

        return redirect()
            ->route('incomingbahanbaku.show', $mechanicalTest->incoming_bahan_baku_id)
            ->with('success', 'Data mechanical test & lampiran berhasil diupdate');
    }


    public function destroyMechanicalTest(MechanicalTest $mechanicalTest)
    {
        $incomingId = $mechanicalTest->incoming_bahan_baku_id;

        $mechanicalTest->delete();

        return redirect()
            ->route('incomingbahanbaku.show', $incomingId)
            ->with('success', 'Mechanical test berhasil dihapus');
    }

    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = IncomingBahanBaku::findOrFail($id);

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
