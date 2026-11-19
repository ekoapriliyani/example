<?php

namespace App\Http\Controllers;

use App\Models\InspeksiGabionrakitFg;
use App\Models\InspeksiGabionrakitFgHandling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspeksiGabionrakitFgHandlingController extends Controller
{
    public function store(Request $request, InspeksiGabionrakitFg $fg)
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
            $handling = InspeksiGabionrakitFgHandling::create([
                'inspeksi_gabionrakit_fg_id' => $fg->id,
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

    public function destroy(InspeksiGabionrakitFg $fg, InspeksiGabionrakitFgHandling $handling)
    {
        if ($handling->inspeksi_gabionrakit_fg_id !== $fg->id) {
            abort(404);
        }

        $handling->delete();

        return back()->with('success', 'Data handling berhasil dihapus.');
    }
}
