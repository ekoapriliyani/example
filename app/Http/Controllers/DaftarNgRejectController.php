<?php

namespace App\Http\Controllers;

use App\Models\InspeksiChainlinkFg;
use App\Models\InspeksiCtFg;
use App\Models\InspeksiFencingFg;
use App\Models\InspeksiGabionpackingFg;
use App\Models\InspeksiKawatDuriFg;
use App\Models\InspeksiRazorpackingFg;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DaftarNgRejectController extends Controller
{
    private const MODULS = ['WM', 'Fencing', 'CTCL', 'Chainlink', 'Kawat Duri', 'Razor Packing', 'Gabion Packing'];
    private const STATUSES = ['NG', 'REJECT'];

    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $startDate = $this->parseDate($request->query('start_date'));
        $endDate = $this->parseDate($request->query('end_date'));

        $status = in_array($request->query('status'), self::STATUSES, true)
            ? $request->query('status')
            : '';

        $modul = in_array($request->query('modul'), self::MODULS, true)
            ? $request->query('modul')
            : '';

        $statuses = $status !== '' ? [$status] : self::STATUSES;

        $wm = ($modul === '' || $modul === 'WM')
            ? InspeksiWmFg::query()
                ->with('inspeksiWm.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiWm', fn($w) => $w->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiWm', fn($w) => $w->whereDate('tanggal', '<=', $endDate)))
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
                ])
            : collect();

        $fencing = ($modul === '' || $modul === 'Fencing')
            ? InspeksiFencingFg::query()
                ->with('inspeksiFencing.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiFencing', fn($f) => $f->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiFencing', fn($f) => $f->whereDate('tanggal', '<=', $endDate)))
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
                ])
            : collect();

        $ct = ($modul === '' || $modul === 'CTCL')
            ? InspeksiCtFg::query()
                ->with('inspeksiCt.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiCt', fn($c) => $c->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiCt', fn($c) => $c->whereDate('tanggal', '<=', $endDate)))
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
                ])
            : collect();

        $chainlink = ($modul === '' || $modul === 'Chainlink')
            ? InspeksiChainlinkFg::query()
                ->with('inspeksiChainlink.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiChainlink', fn($c) => $c->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiChainlink', fn($c) => $c->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_chainlink_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    'tanggal' => $fg->inspeksiChainlink->tanggal,
                    'shift' => $fg->inspeksiChainlink->shift,
                    'nomor_inspeksi' => $fg->inspeksiChainlink->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiChainlink->pro->pro_id,
                    'modul' => 'Chainlink',
                    'qrcode_url' => route('inspeksi_chainlink_fg.qrcode', $fg->id),
                ])
            : collect();

        $kawatDuri = ($modul === '' || $modul === 'Kawat Duri')
            ? InspeksiKawatDuriFg::query()
                ->with('inspeksiKawatDuri.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiKawatDuri', fn($k) => $k->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiKawatDuri', fn($k) => $k->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_kawat_duri_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    'tanggal' => $fg->inspeksiKawatDuri->tanggal,
                    'shift' => $fg->inspeksiKawatDuri->shift,
                    'nomor_inspeksi' => $fg->inspeksiKawatDuri->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiKawatDuri->pro->pro_id,
                    'modul' => 'Kawat Duri',
                    'qrcode_url' => route('inspeksi_kawat_duri_fg.qrcode', $fg->id),
                ])
            : collect();

        $razorPacking = ($modul === '' || $modul === 'Razor Packing')
            ? InspeksiRazorpackingFg::query()
                ->with('inspeksiRazorpacking.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiRazorpacking', fn($r) => $r->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiRazorpacking', fn($r) => $r->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_razorpacking_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    'tanggal' => $fg->inspeksiRazorpacking->tanggal,
                    'shift' => $fg->inspeksiRazorpacking->shift,
                    'nomor_inspeksi' => $fg->inspeksiRazorpacking->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiRazorpacking->pro->pro_id,
                    'modul' => 'Razor Packing',
                    'qrcode_url' => route('inspeksi_razorpacking_fg.qrcode', $fg->id),
                ])
            : collect();

        $gabionPacking = ($modul === '' || $modul === 'Gabion Packing')
            ? InspeksiGabionpackingFg::query()
                ->with('inspeksiGabionpacking.pro')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiGabionpacking', fn($g) => $g->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiGabionpacking', fn($g) => $g->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'inspeksi_gabionpacking_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    'tanggal' => $fg->inspeksiGabionpacking->tanggal,
                    'shift' => $fg->inspeksiGabionpacking->shift,
                    'nomor_inspeksi' => $fg->inspeksiGabionpacking->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiGabionpacking->pro->pro_id,
                    'modul' => 'Gabion Packing',
                    'qrcode_url' => route('inspeksi_gabionpacking_fg.qrcode', $fg->id),
                ])
            : collect();

        $items = $wm
            ->concat($fencing)
            ->concat($ct)
            ->concat($chainlink)
            ->concat($kawatDuri)
            ->concat($razorPacking)
            ->concat($gabionPacking)
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

        return view('daftar_ng_reject.index', [
            'data' => $data,
            'search' => $search,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'modul' => $modul,
        ]);
    }

    /**
     * Terima input date (Y-m-d). Kembalikan null bila kosong/tidak valid
     * agar filter tanggal diabaikan, bukan melempar error 500.
     */
    private function parseDate(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date === false || $date->format('Y-m-d') !== $value) {
            return null;
        }

        return $value;
    }
}
