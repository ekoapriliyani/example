<?php

namespace App\Http\Controllers;

use App\Mail\ShearingFgLotNotification;
use App\Models\InspeksiShearing;
use App\Models\InspeksiShearingFg;
use App\Models\InspeksiShearingFgDetail;
use App\Models\User;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InspeksiShearingFgController extends Controller
{
    public function create(InspeksiShearing $inspeksi_shearing)
    {
        return view('inspeksi_shearing.fg', ['inspeksiShearing' => $inspeksi_shearing]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_shearing_id' => 'required|exists:inspeksi_shearings,id',
            'status'  => 'required|string',
            'qty'     => 'required|integer',
            'weight'  => 'nullable|numeric',
            'packing' => 'required|string',
            'label'   => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $fg = InspeksiShearingFg::create([
            'inspeksi_shearing_id' => $validated['inspeksi_shearing_id'],
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
                $paths[] = $file->store('inspeksi_shearing_fg', 'public');
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

        return redirect()->route('inspeksi_shearing.show', $fg->inspeksi_shearing_id)
            ->with('success', 'Data FG berhasil disimpan.');
    }

    public function edit(InspeksiShearingFg $fg)
    {
        $fg->load(['details', 'inspeksiShearing']);

        return view('inspeksi_shearing.fg.edit', [
            'inspeksiShearing' => $fg->inspeksiShearing,
            'fg'               => $fg,
        ]);
    }

    public function update(Request $request, InspeksiShearingFg $fg)
    {
        $validated = $request->validate([
            'status'  => 'required|string',
            'qty'     => 'required|integer',
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
                $newFiles[] = $file->store('inspeksi_shearing_fg', 'public');
            }
            $fg->update(['files' => $newFiles]);
        }

        $existingIds = $fg->details()->pluck('id')->toArray();
        $submittedIds = $request->input('detail_id', []);
        $toDelete = array_diff($existingIds, $submittedIds);

        if ($toDelete) {
            InspeksiShearingFgDetail::destroy($toDelete);
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
                InspeksiShearingFgDetail::where('id', $detailId)->update([
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
            ->route('inspeksi_shearing.show', $fg->inspeksi_shearing_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    public function destroy(InspeksiShearingFg $fg)
    {
        $inspeksiId = $fg->inspeksi_shearing_id;
        $fg->delete();

        return redirect()->route('inspeksi_shearing.show', $inspeksiId)
            ->with('success', 'Data FG berhasil dihapus');
    }

    private function generateLotNumber(string $prefix): string
    {
        $tahunBulan = now()->format('Ym');
        $prefixWithDate = "{$prefix}-{$tahunBulan}-";

        return DB::transaction(function () use ($prefixWithDate) {
            $maxSeq = DB::table('inspeksi_shearing_fgs')
                ->where('lot_number', 'like', "{$prefixWithDate}%")
                ->whereNotNull('lot_number')
                ->lockForUpdate()
                ->max(DB::raw("CAST(REPLACE(lot_number, '{$prefixWithDate}', '') AS UNSIGNED)"));

            $nextNumber = ($maxSeq ?: 0) + 1;

            return $prefixWithDate . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    private function handleLotNumberAndNotify(InspeksiShearingFg $fg): void
    {
        if (!in_array($fg->status, ['NG', 'REJECT']) || $fg->lot_number) {
            return;
        }

        $prefix = $fg->status === 'NG' ? 'NG-SHEAR' : 'REJ-SHEAR';
        $lotNumber = $this->generateLotNumber($prefix);

        $fg->updateQuietly(['lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        Mail::to($recipients)->send(new ShearingFgLotNotification($fg->fresh(['inspeksiShearing.pro', 'inspeksiShearing.mesin', 'user', 'details'])));
    }

    public function printQrcode(InspeksiShearingFg $fg)
    {
        $fg->load('inspeksiShearing.pro', 'inspeksiShearing.mesin', 'user', 'details');

        $qrContent = "{$fg->lot_number}";
        $options = new QROptions([
            'scale' => 14,
            'quietzoneSize' => 1,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
        ]);
        $qrSvg = (new QRCode($options))->render($qrContent);

        return view('inspeksi_shearing.fg.qrcode', [
            'fg' => $fg,
            'qrSvg' => $qrSvg,
            'inspeksiShearing' => $fg->inspeksiShearing,
            'pro' => $fg->inspeksiShearing->pro,
        ]);
    }
}
