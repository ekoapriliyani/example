<?php

namespace App\Http\Controllers;

use App\Models\InspeksiCtFg;
use App\Models\InspeksiFencingFg;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DaftarNgRejectController extends Controller
{
    private const MODULS = ['WM', 'Fencing', 'CTCL'];
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

        $items = $wm
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
