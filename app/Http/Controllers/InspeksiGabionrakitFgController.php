<?php

namespace App\Http\Controllers;

use App\Mail\GabionrakitFgLotNotification;
use App\Models\InspeksiGabionrakit;
use App\Models\InspeksiGabionrakitFg;
use App\Models\InspeksiGabionrakitFgDetail;
use App\Models\User;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InspeksiGabionrakitFgController extends Controller
{
    public function create(InspeksiGabionrakit $inspeksi_gabionrakit)
    {
        return view('inspeksi_gabionrakit.fg', ['inspeksiGabionrakit' => $inspeksi_gabionrakit]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_gabionrakit_id' => 'required|exists:inspeksi_gabionrakits,id',
            'status'  => 'required|string',
            'qty'     => 'required',
            'weight'  => 'nullable|numeric',
            'packing' => 'required|string',
            'label'   => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $fg = InspeksiGabionrakitFg::create([
            'inspeksi_gabionrakit_id' => $validated['inspeksi_gabionrakit_id'],
            'user_id'  => Auth::id(),
            'status'   => $validated['status'],
            'qty'      => $validated['qty'],
            'weight'   => $validated['weight'],
            'packing'  => $validated['packing'],
            'label'    => $validated['label'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('inspeksi_gabionrakit_fg', 'public');
            }
            $fg->update(['files' => $paths]);
        }

        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $detailQty     = $request->input('detail_qty', []);

        foreach ($descriptions as $i => $description) {
            if (!empty($description)) {
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$i] ?? null,
                    'qty'          => $detailQty[$i] ?? null,
                ]);
            }
        }

        $this->handleLotNumberAndNotify($fg);

        return redirect()->route('inspeksi_gabionrakit.show', $fg->inspeksi_gabionrakit_id)
            ->with('success', 'Data FG berhasil disimpan.');
    }

    public function edit(InspeksiGabionrakitFg $fg)
    {
        $fg->load(['details', 'inspeksiGabionrakit']);

        return view('inspeksi_gabionrakit.fg.edit', [
            'inspeksiGabionrakit' => $fg->inspeksiGabionrakit,
            'fg'                  => $fg,
        ]);
    }

    public function update(Request $request, InspeksiGabionrakitFg $fg)
    {
        $validated = $request->validate([
            'status'  => 'required|string',
            'qty'     => 'required',
            'weight'  => 'nullable|numeric',
            'packing' => 'required|string',
            'label'   => 'required|string',
            'files.*' => 'nullable|file|max:5120',
            'detail_description.*'  => 'nullable|string',
            'detail_description2.*' => 'nullable|string',
            'detail_qty.*'          => 'nullable|integer',
            'detail_id.*'           => 'nullable|integer',
        ]);

        $fg->update([
            'status'  => $validated['status'],
            'qty'     => $validated['qty'],
            'weight'  => $validated['weight'],
            'packing' => $validated['packing'],
            'label'   => $validated['label'],
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
                $newFiles[] = $file->store('inspeksi_gabionrakit_fg', 'public');
            }
            $fg->update(['files' => $newFiles]);
        }

        $existingIds = $fg->details()->pluck('id')->toArray();
        $submittedIds = $request->input('detail_id', []);
        $toDelete = array_diff($existingIds, $submittedIds);

        if ($toDelete) {
            InspeksiGabionrakitFgDetail::destroy($toDelete);
        }

        $descriptions  = $request->input('detail_description', []);
        $descriptions2 = $request->input('detail_description2', []);
        $detailQty     = $request->input('detail_qty', []);

        foreach ($descriptions as $index => $description) {
            if (empty($description) && empty($descriptions2[$index] ?? null) && empty($detailQty[$index] ?? null)) {
                continue;
            }

            $detailId = $submittedIds[$index] ?? null;

            if ($detailId && in_array($detailId, $existingIds)) {
                InspeksiGabionrakitFgDetail::where('id', $detailId)->update([
                    'description'  => $description,
                    'description2' => $descriptions2[$index] ?? null,
                    'qty'          => $detailQty[$index] ?? null,
                ]);
            } else {
                $fg->details()->create([
                    'description'  => $description,
                    'description2' => $descriptions2[$index] ?? null,
                    'qty'          => $detailQty[$index] ?? null,
                ]);
            }
        }

        $this->handleLotNumberAndNotify($fg);

        return redirect()
            ->route('inspeksi_gabionrakit.show', $fg->inspeksi_gabionrakit_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    public function destroy(InspeksiGabionrakitFg $fg)
    {
        $inspeksiId = $fg->inspeksi_gabionrakit_id;
        $fg->delete();

        return redirect()->route('inspeksi_gabionrakit.show', $inspeksiId)
            ->with('success', 'Data FG berhasil dihapus');
    }

    private function generateLotNumber(string $prefix): string
    {
        $tahunBulan = now()->format('Ym');
        $prefixWithDate = "{$prefix}-{$tahunBulan}-";

        return DB::transaction(function () use ($prefixWithDate) {
            $maxSeq = DB::table('inspeksi_gabionrakit_fgs')
                ->where('lot_number', 'like', "{$prefixWithDate}%")
                ->whereNotNull('lot_number')
                ->lockForUpdate()
                ->max(DB::raw("CAST(REPLACE(lot_number, '{$prefixWithDate}', '') AS UNSIGNED)"));

            $nextNumber = ($maxSeq ?: 0) + 1;

            return $prefixWithDate . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    private function handleLotNumberAndNotify(InspeksiGabionrakitFg $fg): void
    {
        if (!in_array($fg->status, ['NG', 'REJECT']) || $fg->lot_number) {
            return;
        }

        $prefix = $fg->status === 'NG' ? 'NG-RAKIT' : 'REJ-RAKIT';
        $lotNumber = $this->generateLotNumber($prefix);

        $fg->updateQuietly(['lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        Mail::to($recipients)->send(new GabionrakitFgLotNotification($fg->fresh(['inspeksiGabionrakit.pro', 'inspeksiGabionrakit.mesin', 'user', 'details'])));
    }

    public function printQrcode(InspeksiGabionrakitFg $fg)
    {
        $fg->load('inspeksiGabionrakit.pro', 'inspeksiGabionrakit.mesin', 'user', 'details');

        $qrContent = "{$fg->lot_number}";
        $options = new QROptions([
            'scale' => 14,
            'quietzoneSize' => 1,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
        ]);
        $qrSvg = (new QRCode($options))->render($qrContent);

        return view('inspeksi_gabionrakit.fg.qrcode', [
            'fg' => $fg,
            'qrSvg' => $qrSvg,
            'inspeksiGabionrakit' => $fg->inspeksiGabionrakit,
            'pro' => $fg->inspeksiGabionrakit->pro,
        ]);
    }
}
