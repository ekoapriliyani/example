<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\InspeksiWmFg;
use App\Models\InspeksiWmFgDetail;
use App\Mail\FgLotNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InspeksiWmFgController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(InspeksiWm $inspeksi_wm)
    {
        return view('inspeksi_wm.fg', ['inspeksi_wm' => $inspeksi_wm]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspeksi_wm_id' => 'required|exists:inspeksi_wms,id',
            'status'         => 'required|string',
            'qty'            => 'required|integer',
            'weight'         => 'nullable|numeric',
            'packing'        => 'required|string',
            'label'          => 'required|string',
            'files.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $fg = InspeksiWmFg::create([
            'inspeksi_wm_id' => $validated['inspeksi_wm_id'],
            'user_id'        => Auth::id(),
            'status'         => $validated['status'],
            'qty'            => $validated['qty'],
            'weight'         => $validated['weight'],
            'packing'        => $validated['packing'],
            'label'          => $validated['label'],
        ]);

        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('inspeksi_wm_fg', 'public');
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

        return redirect()->route('inspeksi_wm.show', $fg->inspeksi_wm_id)
            ->with('success', 'Data FG, detail, dan file berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWmFg $fg)
    {
        $fg->load(['details', 'inspeksiWm']);

        return view('inspeksi_wm.fg.edit', [
            'inspeksi_wm' => $fg->inspeksiWm,
            'fg'          => $fg,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWmFg $fg)
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
                $newFiles[] = $file->store('inspeksi_wm_fg', 'public');
            }
            $fg->update(['files' => $newFiles]);
        }

        $existingIds = $fg->details()->pluck('id')->toArray();
        $submittedIds = $request->input('detail_id', []);
        $toDelete = array_diff($existingIds, $submittedIds);

        if ($toDelete) {
            InspeksiWmFgDetail::destroy($toDelete);
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
                InspeksiWmFgDetail::where('id', $detailId)->update([
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
            ->route('inspeksi_wm.show', $fg->inspeksi_wm_id)
            ->with('success', 'Data FG berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiWmFg $fg)
    {
        $inspeksiWmId = $fg->inspeksi_wm_id;

        $fg->delete();

        return redirect()->route('inspeksi_wm.show', $inspeksiWmId)
            ->with('success', 'Data FG berhasil dihapus');
    }

    private function generateLotNumber(string $prefix): string
    {
        $tahunBulan = now()->format('Ym');
        $prefixWithDate = "{$prefix}-{$tahunBulan}-";

        $lastRecord = InspeksiWmFg::where('lot_number', 'like', "{$prefixWithDate}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefixWithDate, '', $lastRecord->lot_number);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        return "{$prefixWithDate}" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function handleLotNumberAndNotify(InspeksiWmFg $fg): void
    {
        if (!in_array($fg->status, ['NG', 'REJECT']) || $fg->lot_number) {
            return;
        }

        $prefix = $fg->status === 'NG' ? 'NG-WM' : 'REJ-WM';
        $lotNumber = $this->generateLotNumber($prefix);

        $fg->updateQuietly(['lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        Mail::to($recipients)->send(new FgLotNotification($fg->fresh(['inspeksiWm.pro', 'user', 'details'])));
    }
}
