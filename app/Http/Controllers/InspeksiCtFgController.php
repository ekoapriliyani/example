<?php

namespace App\Http\Controllers;

use App\Mail\CtFgLotNotification;
use App\Models\InspeksiCt;
use App\Models\InspeksiCtFg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class InspeksiCtFgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $id)
    {
        $inspeksiCt = InspeksiCt::findOrFail($id);
        return view('inspeksi_ct.fg', ['inspeksiCt' => $inspeksiCt]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'inspeksi_ct_id' => 'required|exists:inspeksi_cts,id',
            'status'                 => 'required',
            'packing'                 => 'required',
            'label'                 => 'required',
            'qty'                    => 'required',
            'weight'                 => 'required',
            'files.*'                => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data FG utama
        $fg = InspeksiCtFg::create([
            'inspeksi_ct_id' => $validated['inspeksi_ct_id'],
            'user_id'                => Auth::id(),
            'status'                 => $validated['status'],
            'packing'                 => $validated['packing'],
            'label'                 => $validated['label'],
            'qty'                    => $validated['qty'],
            'weight'                 => $validated['weight'],
        ]);
        // simpan file multiple ke kolom JSON
        if ($request->hasFile('files')) {
            $paths = [];

            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('uploads/inspeksi_ct_fg', 'public');
            }

            $fg->update([
                'files' => $paths
            ]);
        }

        // simpan detail multiple (array)
        // ambil semua array dari request
        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $qty           = $request->input('detail_qty', []);

        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $qty[$i] ?? null,
                ]);
            }
        }

        $this->handleLotNumberAndNotify($fg);

        return redirect()->route('inspeksi_ct.show', $validated['inspeksi_ct_id'])
            ->with('success', 'Data FG berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fg = InspeksiCtFg::with(['details', 'inspeksiCt'])->findOrFail($id);

        return view('inspeksi_ct.fg.edit', [
            'inspeksi_ct' => $fg->inspeksiCt,
            'fg' => $fg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string',
            'qty' => 'required|integer',
            'weight' => 'required|numeric',
            'files.*' => 'nullable|file|max:5120',

            'detail_description.*' => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*' => 'nullable|integer',
        ]);

        $fg = InspeksiCtFg::findOrFail($id);
        $fg->update([
            'status' => $request->status,
            'qty' => $request->qty,
            'weight' => $request->weight,
        ]);
        if ($request->hasFile('files')) {
            if (is_array($fg->files)) {
                foreach ($fg->files as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $newFiles[] = $file->store('inspeksi_ct_fg', 'public');
            }
            $fg->update([
                'files' => $newFiles,
            ]);
        }
        $fg->details()->delete();
        if ($request->detail_description) {
            foreach ($request->detail_description as $index => $description) {
                $description2 = $request->detail_description2[$index] ?? null;
                $qty = $request->detail_qty[$index] ?? null;

                if (empty($description) && empty($description2) && empty($qty)) {
                    continue;
                }

                $fg->details()->create([
                    'description' => $description,
                    'description2' => $description2,
                    'qty' => $qty,
                ]);
            }
        }

        $this->handleLotNumberAndNotify($fg);

        return redirect()
            ->route('inspeksi_ct.show', $fg->inspeksi_ct_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fg = InspeksiCtFg::findOrFail($id);
        $inspeksiCtId = $fg->inspeksi_ct_id; // Simpan ID inspeksi_ct sebelum menghapus FG
        $fg->delete();

        return redirect()->route('inspeksi_ct.show', $inspeksiCtId)
            ->with('success', 'Data FG berhasil dihapus');
    }

    private function generateLotNumber(string $prefix): string
    {
        $tahunBulan = now()->format('Ym');
        $prefixWithDate = "{$prefix}-{$tahunBulan}-";

        return DB::transaction(function () use ($prefixWithDate) {
            $maxSeq = DB::table('inspeksi_ct_fgs')
                ->where('lot_number', 'like', "{$prefixWithDate}%")
                ->whereNotNull('lot_number')
                ->lockForUpdate()
                ->max(DB::raw("CAST(REPLACE(lot_number, '{$prefixWithDate}', '') AS UNSIGNED)"));

            $nextNumber = ($maxSeq ?: 0) + 1;

            return $prefixWithDate . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    private function handleLotNumberAndNotify(InspeksiCtFg $fg): void
    {
        if (!in_array($fg->status, ['NG', 'REJECT']) || $fg->lot_number) {
            return;
        }

        $prefix = $fg->status === 'NG' ? 'NG-CT' : 'REJ-CT';
        $lotNumber = $this->generateLotNumber($prefix);

        $fg->updateQuietly(['lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        Mail::to($recipients)->send(new CtFgLotNotification($fg->fresh(['inspeksiCt.pro', 'inspeksiCt.mesin', 'user', 'details'])));
    }

    public function printQrcode(InspeksiCtFg $fg)
    {
        $fg->load('inspeksiCt.pro', 'details');

        $qrContent = "Lot Number: {$fg->lot_number}\n"
            . "No. Inspeksi: {$fg->inspeksiCt->nomor_inspeksi}\n"
            . "PRO: {$fg->inspeksiCt->pro->pro_id}\n"
            . "Desc: {$fg->inspeksiCt->pro->description}\n"
            . "Qty: {$fg->qty} | Weight: {$fg->weight} Kg\n"
            . "Alasan:\n";

        foreach ($fg->details as $d) {
            $qrContent .= "- {$d->description}";
            if ($d->description2) $qrContent .= " — {$d->description2}";
            $qrContent .= "\n";
        }

        $options = new QROptions([
            'scale' => 10,
            'quietzoneSize' => 1,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
        ]);
        $qrSvg = (new QRCode($options))->render($qrContent);

        return view('inspeksi_ct.fg.qrcode', [
            'fg' => $fg,
            'qrSvg' => $qrSvg,
            'inspeksiCt' => $fg->inspeksiCt,
            'pro' => $fg->inspeksiCt->pro,
        ]);
    }
}
