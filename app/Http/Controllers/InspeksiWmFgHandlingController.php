<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWmFg;
use App\Models\InspeksiWmFgHandling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspeksiWmFgHandlingController extends Controller
{
    public function store(Request $request, InspeksiWmFg $fg)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.status' => 'required|in:OK,NG,REJECT,REPAIR,SCRAP,DOWNGRADE',
            'details.*.qty' => 'required|integer|min:0',
            'details.*.weight' => 'required|numeric|min:0',
        ], [
            'details.required' => 'Minimal 1 detail handling harus diisi.',
            'details.*.status.required' => 'Status harus dipilih.',
            'details.*.status.in' => 'Status tidak valid.',
            'details.*.qty.required' => 'Qty harus diisi.',
            'details.*.qty.min' => 'Qty tidak boleh negatif.',
            'details.*.weight.required' => 'Weight harus diisi.',
            'details.*.weight.min' => 'Weight tidak boleh negatif.',
        ]);

        if (!in_array($fg->status, ['NG', 'REJECT'])) {
            return back()->with('error', 'Hanya lot dengan status NG atau REJECT yang bisa di-handle.');
        }

        DB::transaction(function () use ($fg, $validated) {
            $handling = InspeksiWmFgHandling::create([
                'inspeksi_wm_fg_id' => $fg->id,
                'tanggal' => $validated['tanggal'],
                'user_id' => auth()->id(),
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($validated['details'] as $detail) {
                $handling->details()->create([
                    'status' => $detail['status'],
                    'qty' => $detail['qty'],
                    'weight' => $detail['weight'],
                ]);
            }
        });

        return back()->with('success', 'Handling NG/REJECT berhasil disimpan.');
    }

    public function destroy(InspeksiWmFg $fg, InspeksiWmFgHandling $handling)
    {
        if ($handling->inspeksi_wm_fg_id !== $fg->id) {
            abort(404);
        }

        $handling->delete();

        return back()->with('success', 'Data handling berhasil dihapus.');
    }
}
