<?php

namespace App\Http\Controllers;

use App\Models\Outgoing;
use App\Models\OutgoingInspeksi;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = Outgoing::with('shipment') // Eager loading relasi shipment
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc') // Lebih aman menggunakan parameter waktu pembuatan data
            ->paginate(10)
            ->withQueryString();

        return view('outgoing.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Ambil format Tahun dan Bulan saat ini (Contoh: 202606)
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "OUT{$tahunBulan}";

        // 2. PERBAIKAN: Urutkan berdasarkan 'id' desc agar mendapatkan rekor TERAKHIR yang valid
        $lastRecord = Outgoing::where('nomor_inspeksi', 'like', "{$prefix}%")
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
        $nextNomor = "{$prefix}{$paddedNumber}"; // Hasil: OUT202606001

        // 4. Ambil data Shipment
        $shipments = Shipment::orderBy('shipment_id')->get();

        return view('outgoing.create', compact('nextNomor', 'shipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'shipment_id' => 'nullable',
            'no_do' => 'nullable',
            'produk' => 'nullable',
            'lokasi' => 'required',
            'keterangan' => 'nullable',
            'no_kendaraan' => 'required',
            'files' => 'nullable|array',
            'files.*' => 'nullable|image|max:20480',
        ]);

        // 1. Generate ulang nomor inspeksi tepat sebelum menyimpan demi menghindari duplikasi data
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "OUT{$tahunBulan}";

        $lastRecord = Outgoing::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $fixNomorInspeksi = "{$prefix}{$paddedNumber}";

        // 2. Masukkan nomor inspeksi DAN user_id yang sedang login ke array validated
        $validated['nomor_inspeksi'] = $fixNomorInspeksi;
        $validated['user_id'] = auth()->id(); // <--- Tambahkan baris ini

        // 3. Simpan data utama ke database
        $out = Outgoing::create($validated);

        // 4. Proses upload file jika ada
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paths[] = $file->storeAs(
                    'uploads/outgoing',
                    $name,
                    'public'
                );
            }
            $out->update([
                'files' => $paths
            ]);
        }

        return redirect()->route('outgoing.index')->with('success', "Data outgoing {$fixNomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Outgoing $outgoing)
    {
        $outgoing->load('shipment');
        return view('outgoing.show', compact('outgoing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Outgoing::findOrFail($id);
        $shipments = Shipment::orderBy('shipment_id')->get();
        return view('outgoing.edit', compact('data', 'shipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'shipment_id' => 'nullable',
            'no_do' => 'nullable',
            'produk' => 'nullable',
            'lokasi' => 'required',
            'no_kendaraan' => 'required',
            'keterangan' => 'nullable',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|max:5120',
        ]);

        $item = Outgoing::findOrFail($id);

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
                    'uploads/outgoing',
                    $name,
                    'public'
                );
            }
            $item->update([
                'files' => $paths,
            ]);
        }
        return redirect()
            ->route('outgoing.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Outgoing::findOrFail($id);

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
            ->route('outgoing.index')
            ->with('success', 'Data berhasil dihapus');
    }


    public function createInspeksi($id)
    {
        $outgoing = Outgoing::findOrFail($id);
        $shipments = Shipment::all();

        return view('outgoing.inspeksi_create', compact('outgoing', 'shipments'));
    }

    public function storeInspeksi(Request $request, $id)
    {
        $outgoing = Outgoing::findOrFail($id);

        $validated = $request->validate([
            'label'      => 'required|in:OK,NG,-', // <-- Tambahkan ,- di sini
            'karat'      => 'required|in:OK,NG,-',
            'penyok'     => 'required|in:OK,NG,-',
            'kotor'      => 'required|in:OK,NG,-',
            'galvanized' => 'required|in:OK,NG,-',
            'lasan'      => 'required|in:OK,NG,-',
            'mesh'       => 'required|in:OK,NG,-', // <-- Ini yang menyebabkan error tadi
            'pvc'        => 'required|in:OK,NG,-',
            'packing'    => 'required|in:OK,NG,-',
            'qty'        => 'required|in:OK,NG,-',
            'files'      => 'nullable|array',
            'files.*'    => 'nullable|image|max:20480',
        ]);

        // Tambahkan user_id yang sedang login
        $validated['user_id'] = auth()->id();
        $validated['outgoing_id'] = $outgoing->id;

        // Simpan data inspeksi
        $inspeksi = $outgoing->outgoinginspeksi()->create($validated);

        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/outgoing', 'public');
            }
            $inspeksi->update(['files' => $paths]);
        }

        return redirect()->route('outgoing.show', ['outgoing' => $outgoing->id])
            ->with('success', "Data inspeksi berhasil disimpan");
    }

    public function editInspeksi(Outgoing $outgoing, OutgoingInspeksi $inspeksi)
    {
        return view(
            'outgoing.inspeksi.edit',
            compact('outgoing', 'inspeksi')
        );
    }

    public function updateInspeksi(Request $request, $outgoing_id, $inspeksi_id)
    {
        // 1. Validasi data input (Termasuk validasi file)
        $validated = $request->validate([
            'label'      => 'required|in:OK,NG,-',
            'karat'      => 'required|in:OK,NG,-',
            'penyok'     => 'required|in:OK,NG,-',
            'kotor'      => 'required|in:OK,NG,-',
            'galvanized' => 'required|in:OK,NG,-',
            'lasan'      => 'required|in:OK,NG,-',
            'mesh'       => 'required|in:OK,NG,-',
            'pvc'        => 'required|in:OK,NG,-',
            'packing'    => 'required|in:OK,NG,-',
            'qty'        => 'required|in:OK,NG,-',
            'files'      => 'nullable|array',
            'files.*'    => 'nullable|image|max:20480',
        ]);

        // Cari data inspeksi yang sudah ada (jika ada) untuk proses hapus file lama
        $inspeksi = OutgoingInspeksi::where('outgoing_id', $outgoing_id)->first();

        if ($request->hasFile('files')) {
            // Hapus file lama jika sebelumnya sudah ada datanya di DB
            if ($inspeksi && $inspeksi->files) {
                foreach ($inspeksi->files as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }

            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                // Menggunakan storeAs agar nama file unik seperti di method store sebelumnya
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs(
                    'uploads/outgoing',
                    $name,
                    'public'
                );
                $uploadedFiles[] = $path;
            }

            // Masukkan array path baru ke data yang akan disimpan
            $validated['files'] = $uploadedFiles;
        }

        // 2. Simpan atau perbarui data inspeksi checklist QC
        $inspeksiData = OutgoingInspeksi::updateOrCreate(
            ['outgoing_id' => $outgoing_id],
            array_merge($validated, ['user_id' => auth()->id()])
        );

        return redirect()->route('outgoing.show', $outgoing_id)->with('success', 'Data inspeksi dan dokumentasi berhasil diperbarui!');
    }

    public function destroyInspeksi($id)
    {
        $inspeksi = OutgoingInspeksi::findOrFail($id);
        // Hapus data inspeksi
        $inspeksi->delete();
        return redirect()->back()->with('success', 'Data inspeksi berhasil dihapus');
    }


    public function toggleApproval($id)
    {
        if (! in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $inspeksi = Outgoing::findOrFail($id);

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
