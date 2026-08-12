<?php

namespace App\Http\Controllers;

use App\Models\InspeksiCtFg;
use App\Models\InspeksiFencingFg;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DaftarNgRejectController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $wm = InspeksiWmFg::query()
            ->with('inspeksiWm.pro')
            ->whereIn('status', ['NG', 'REJECT'])
            ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_wm_id'])
            ->map(fn($fg) => [
                'id' => $fg->id,
                'lot_number' => $fg->lot_number,
                'status' => $fg->status,
                'qty' => $fg->qty,
                'tanggal' => $fg->inspeksiWm->tanggal,
                'shift' => $fg->inspeksiWm->shift,
                'nomor_inspeksi' => $fg->inspeksiWm->nomor_inspeksi,
                'pro_number' => $fg->inspeksiWm->pro->pro_id,
                'modul' => 'WM',
                'qrcode_url' => route('inspeksi_wm_fg.qrcode', $fg->id),
            ]);

        $fencing = InspeksiFencingFg::query()
            ->with('inspeksiFencing.pro')
            ->whereIn('status', ['NG', 'REJECT'])
            ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_fencing_id'])
            ->map(fn($fg) => [
                'id' => $fg->id,
                'lot_number' => $fg->lot_number,
                'status' => $fg->status,
                'qty' => $fg->qty,
                'tanggal' => $fg->inspeksiFencing->tanggal,
                'shift' => $fg->inspeksiFencing->shift,
                'nomor_inspeksi' => $fg->inspeksiFencing->nomor_inspeksi,
                'pro_number' => $fg->inspeksiFencing->pro->pro_id,
                'modul' => 'Fencing',
                'qrcode_url' => route('inspeksi_fencing_fg.qrcode', $fg->id),
            ]);

        $ct = InspeksiCtFg::query()
            ->with('inspeksiCt.pro')
            ->whereIn('status', ['NG', 'REJECT'])
            ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_ct_id'])
            ->map(fn($fg) => [
                'id' => $fg->id,
                'lot_number' => $fg->lot_number,
                'status' => $fg->status,
                'qty' => $fg->qty,
                'tanggal' => $fg->inspeksiCt->tanggal,
                'shift' => $fg->inspeksiCt->shift,
                'nomor_inspeksi' => $fg->inspeksiCt->nomor_inspeksi,
                'pro_number' => $fg->inspeksiCt->pro->pro_id,
                'modul' => 'CTCL',
                'qrcode_url' => route('inspeksi_ct_fg.qrcode', $fg->id),
            ]);

        $items = collect($wm)
            ->concat($fencing)
            ->concat($ct)
            ->filter(fn($item) => !empty($item['lot_number']));

        if ($search !== '') {
            $items = $items->filter(fn($item) => str_contains($item['lot_number'], $search));
        }

        $items = $items->sortByDesc('lot_number')->values();

        $perPage = 15;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $data = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('daftar_ng_reject.index', ['data' => $data, 'search' => $search]);
    }
}
