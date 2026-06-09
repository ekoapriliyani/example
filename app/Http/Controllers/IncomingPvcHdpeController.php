<?php

namespace App\Http\Controllers;

use App\Models\IncomingPvcHdpe;
use App\Models\IncomingPvcHdpeInspeksi;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncomingPvcHdpeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IncomingPvcHdpe::all();
        return view('incomingpvchdpe.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $lastRecord = IncomingPvcHdpe::where('nomor_inspeksi', 'like', "INPVCHDPE{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace("INPVCHDPE{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nextNomor = "INPVCHDPE{$tahunBulan}{$nextNumber}";
        $suppliers = Supplier::orderBy('supplier_code')->get();
        return view('incomingpvchdpe.create', compact('nextNomor', 'suppliers'));
    }



    public function createInspeksi($id)
    {
        $incomingpvchdpe = IncomingPvcHdpe::findOrFail($id);

        return view('incomingpvchdpe.inspeksi', compact('incomingpvchdpe'));
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
            'no_sj' => 'nullable|string',
            'certificate' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        $tanggalInput = Carbon::now();
        $tahunBulan = $tanggalInput->format('Ym');

        $lastRecord = IncomingPvcHdpe::where('nomor_inspeksi', 'like', "INPVCHDPE{$tahunBulan}%")
            ->orderBy('nomor_inspeksi', 'desc')
            ->first();

        if (!$lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumberStr = str_replace("INPVCHDPE{$tahunBulan}", "", $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $nomorOtomatis = "INPVCHDPE{$tahunBulan}{$nextNumber}";


        $inpvchdpe = IncomingPvcHdpe::create([
            'tanggal' => $validated['tanggal'],
            'nomor_inspeksi' => $nomorOtomatis,
            'supplier_id' => $validated['supplier_id'],
            'no_po' => $validated['no_po'],
            'no_sj' => $validated['no_sj'],
            'certificate' => $validated['certificate'],
        ]);
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paths[] = $file->storeAs(
                    'uploads/incomingpvchdpe',
                    $name,
                    'public'
                );
            }
            $inpvchdpe->update([
                'files' => $paths
            ]);
        }
        return redirect()->route('incomingpvchdpe.index')->with('success', 'data incoming berhasil disimpan');
    }



    // store inspeksi
    public function storeInspeksi(Request $request, $id)
    {
        $validated = $request->validate([
            'warna'  => 'required',
            'status'  => 'required|in:OK,NG',
            'keterangan' => 'nullable|string',
            'files'   => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        $inpvchdpe = IncomingPvcHdpeInspeksi::create([
            'incoming_pvc_hdpe_id' => $id,
            'user_id' => Auth::id(),
            'warna' => $validated['warna'],
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $paths[] = $file->storeAs(
                    'uploads/incomingpvchdpe',
                    $name,
                    'public'
                );
            }

            $inpvchdpe->update([
                'files' => $paths
            ]);
        }

        return redirect()
            ->route('incomingpvchdpe.show', $id)
            ->with('success', 'Data inspeksi berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(IncomingPvcHdpe $incomingpvchdpe)
    {
        return view('incomingpvchdpe.show', compact('incomingpvchdpe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = IncomingPvcHdpe::findOrFail($id);
        $suppliers = Supplier::all();

        return view('incomingpvchdpe.edit', compact('data', 'suppliers'));
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
            'no_sj' => '',
        ]);

        $incomingPvcHdpe = IncomingPvcHdpe::findOrFail($id);
        $incomingPvcHdpe->update($validated);
        if ($request->hasFile('files')) {
            // hapus file lama
            if (!empty($incomingPvcHdpe->files)) {
                foreach ($incomingPvcHdpe->files as $oldFile) {

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
                    'uploads/sheetgalvanize',
                    $name,
                    'public'
                );
            }
            $incomingPvcHdpe->update([
                'files' => $paths,
            ]);
        }

        return redirect()->route('incomingpvchdpe.index')->with('success', 'Data incoming berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incomingPvcHdpe = IncomingPvcHdpe::findOrFail($id);
        $incomingPvcHdpe->delete();

        return redirect()->route('incomingpvchdpe.index')->with('success', 'Data incoming berhasil dihapus');
    }

    public function destroyInspeksi($id)
    {
        // 1. Cari data inspeksi berdasarkan ID
        // Sesuaikan nama Model 'IncomingPvcHdpeInspeksi' dengan yang ada di sitemmu
        $inspeksi = IncomingPvcHdpeInspeksi::findOrFail($id);

        try {
            // 2. Hapus file/gambar lampiran dari storage jika ada
            if ($inspeksi->files) {
                foreach ($inspeksi->files as $file) {
                    // Proteksi jika data tersimpan sebagai array didalam array
                    $actualPath = is_array($file) ? ($file[0] ?? '') : $file;

                    if (!empty($actualPath) && Storage::disk('public')->exists($actualPath)) {
                        Storage::disk('public')->delete($actualPath);
                    }
                }
            }

            // 3. Hapus data dari database
            $inspeksi->delete();

            return redirect()->back()->with('success', 'Item inspeksi PVC/HDPE berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }



    // 1. Method untuk menampilkan halaman edit
    public function editInspeksi($incomingpvchdpe_id, $inspeksi_id)
    {
        // Cari data inspeksi child berdasarkan ID
        $inspeksi = IncomingPvcHdpeInspeksi::findOrFail($inspeksi_id);

        // Lempar data ke view edit yang kita buat sebelumnya
        return view('incomingpvchdpe.inspeksi.edit', compact('inspeksi'));
    }

    // 2. Method untuk memproses update data ke database
    public function updateInspeksi(Request $request, $id)
    {
        $inspeksi = IncomingPvcHdpeInspeksi::findOrFail($id);

        $validated = $request->validate([
            'warna' => 'nullable|string',
            'status' => 'required|string|in:OK,NG',
            'keterangan' => 'nullable|string',
            'files.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Ambil default berkas lama jika ada
        $arrFiles = $inspeksi->files ?? [];

        // Jika operator mengunggah file/gambar baru
        if ($request->hasFile('files')) {
            // Hapus file fisik lama di storage agar hemat ruang disk
            if (!empty($inspeksi->files)) {
                foreach ($inspeksi->files as $oldFile) {
                    $actualPath = is_array($oldFile) ? ($oldFile[0] ?? '') : $oldFile;
                    if (!empty($actualPath) && Storage::disk('public')->exists($actualPath)) {
                        Storage::disk('public')->delete($actualPath);
                    }
                }
            }

            // Simpan file-file baru
            $arrFiles = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('incoming_pvc_hdpe', 'public');
                $arrFiles[] = $path;
            }
        }

        $validated['files'] = $arrFiles;

        // Jalankan update ke database
        $inspeksi->update($validated);

        return redirect()
            ->route('incomingpvchdpe.show', $inspeksi->incoming_pvc_hdpe_id) // Sesuaikan nama foreign key induknya
            ->with('success', 'Data inspeksi PVC/HDPE berhasil diperbarui!');
    }
}
