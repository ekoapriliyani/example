<?php

namespace App\Http\Controllers;

use App\Exports\DaftarNgRejectExport;
use App\Models\InspeksiChainlinkFg;
use App\Models\InspeksiCtFg;
use App\Models\InspeksiFencingFg;
use App\Models\InspeksiGabionanyamFg;
use App\Models\InspeksiGabionpackingFg;
use App\Models\InspeksiKawatDuriFg;
use App\Models\InspeksiRazorpackingFg;
use App\Models\InspeksiShearingFg;
use App\Models\InspeksiWmFg;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DaftarNgRejectController extends Controller
{
    private const MODULS = ['WM', 'Fencing', 'CTCL', 'Chainlink', 'Kawat Duri', 'Razor Packing', 'Gabion Packing', 'Gabion Anyam', 'Shearing'];
    private const STATUSES = ['NG', 'REJECT'];

    public function index(Request $request)
    {
        $filters = $this->filters($request);
        $items = $this->items($filters);

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
            'search' => $filters['search'],
            'startDate' => $filters['startDate'],
            'endDate' => $filters['endDate'],
            'status' => $filters['status'],
            'modul' => $filters['modul'],
        ]);
    }

    public function export(Request $request)
    {
        $items = $this->items($this->filters($request));

        return Excel::download(
            new DaftarNgRejectExport($items),
            'daftar-ng-reject_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Filter yang dipakai bersama oleh halaman index dan export.
     */
    private function filters(Request $request): array
    {
        return [
            'search' => trim((string) $request->query('search', '')),
            'startDate' => $this->parseDate($request->query('start_date')),
            'endDate' => $this->parseDate($request->query('end_date')),
            'status' => in_array($request->query('status'), self::STATUSES, true)
                ? $request->query('status')
                : '',
            'modul' => in_array($request->query('modul'), self::MODULS, true)
                ? $request->query('modul')
                : '',
        ];
    }

    /**
     * Kumpulkan seluruh data NG/REJECT dari semua modul sesuai filter.
     */
    private function items(array $filters): Collection
    {
        $search = $filters['search'];
        $startDate = $filters['startDate'];
        $endDate = $filters['endDate'];
        $status = $filters['status'];
        $modul = $filters['modul'];

        $statuses = $status !== '' ? [$status] : self::STATUSES;

        $wm = ($modul === '' || $modul === 'WM')
            ? InspeksiWmFg::query()
                ->with('inspeksiWm.pro', 'inspeksiWm.mesin', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiWm', fn($w) => $w->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiWm', fn($w) => $w->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_wm_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiWm->tanggal,
                    'shift' => $fg->inspeksiWm->shift,
                    'nomor_inspeksi' => $fg->inspeksiWm->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiWm->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiWm->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiWm->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'WM',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_wm_fg.qrcode', $fg->id),
                ])
            : collect();

        $fencing = ($modul === '' || $modul === 'Fencing')
            ? InspeksiFencingFg::query()
                ->with('inspeksiFencing.pro', 'inspeksiFencing.mesin', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiFencing', fn($f) => $f->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiFencing', fn($f) => $f->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_fencing_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiFencing->tanggal,
                    'shift' => $fg->inspeksiFencing->shift,
                    'nomor_inspeksi' => $fg->inspeksiFencing->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiFencing->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiFencing->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiFencing->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'Fencing',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_fencing_fg.qrcode', $fg->id),
                ])
            : collect();

        $ct = ($modul === '' || $modul === 'CTCL')
            ? InspeksiCtFg::query()
                ->with('inspeksiCt.pro', 'inspeksiCt.mesin', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiCt', fn($c) => $c->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiCt', fn($c) => $c->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_ct_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiCt->tanggal,
                    'shift' => $fg->inspeksiCt->shift,
                    'nomor_inspeksi' => $fg->inspeksiCt->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiCt->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiCt->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiCt->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'CTCL',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_ct_fg.qrcode', $fg->id),
                ])
            : collect();

        $chainlink = ($modul === '' || $modul === 'Chainlink')
            ? InspeksiChainlinkFg::query()
                ->with('inspeksiChainlink.pro', 'inspeksiChainlink.mesin', 'inspeksiChainlinkFgDetails', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiChainlink', fn($c) => $c->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiChainlink', fn($c) => $c->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_chainlink_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiChainlink->tanggal,
                    'shift' => $fg->inspeksiChainlink->shift,
                    'nomor_inspeksi' => $fg->inspeksiChainlink->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiChainlink->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiChainlink->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiChainlink->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->inspeksiChainlinkFgDetails, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->inspeksiChainlinkFgDetails, 'description2'),
                    'modul' => 'Chainlink',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_chainlink_fg.qrcode', $fg->id),
                ])
            : collect();

        $kawatDuri = ($modul === '' || $modul === 'Kawat Duri')
            ? InspeksiKawatDuriFg::query()
                ->with('inspeksiKawatDuri.pro', 'inspeksiKawatDuri.mesin', 'inspeksiKdFgDetails', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiKawatDuri', fn($k) => $k->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiKawatDuri', fn($k) => $k->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_kawat_duri_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiKawatDuri->tanggal,
                    'shift' => $fg->inspeksiKawatDuri->shift,
                    'nomor_inspeksi' => $fg->inspeksiKawatDuri->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiKawatDuri->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiKawatDuri->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiKawatDuri->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->inspeksiKdFgDetails, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->inspeksiKdFgDetails, 'description2'),
                    'modul' => 'Kawat Duri',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_kawat_duri_fg.qrcode', $fg->id),
                ])
            : collect();

        $razorPacking = ($modul === '' || $modul === 'Razor Packing')
            ? InspeksiRazorpackingFg::query()
                ->with('inspeksiRazorpacking.pro', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiRazorpacking', fn($r) => $r->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiRazorpacking', fn($r) => $r->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_razorpacking_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiRazorpacking->tanggal,
                    'shift' => $fg->inspeksiRazorpacking->shift,
                    'nomor_inspeksi' => $fg->inspeksiRazorpacking->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiRazorpacking->pro->pro_id,
                    'kode_mesin' => '-',
                    'description' => $fg->inspeksiRazorpacking->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'Razor Packing',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_razorpacking_fg.qrcode', $fg->id),
                ])
            : collect();

        $gabionPacking = ($modul === '' || $modul === 'Gabion Packing')
            ? InspeksiGabionpackingFg::query()
                ->with('inspeksiGabionpacking.pro', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiGabionpacking', fn($g) => $g->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiGabionpacking', fn($g) => $g->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_gabionpacking_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiGabionpacking->tanggal,
                    'shift' => $fg->inspeksiGabionpacking->shift,
                    'nomor_inspeksi' => $fg->inspeksiGabionpacking->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiGabionpacking->pro->pro_id,
                    'kode_mesin' => '-',
                    'description' => $fg->inspeksiGabionpacking->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'Gabion Packing',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_gabionpacking_fg.qrcode', $fg->id),
                ])
            : collect();

        $gabionAnyam = ($modul === '' || $modul === 'Gabion Anyam')
            ? InspeksiGabionanyamFg::query()
                ->with('inspeksiGabionanyam.pro', 'inspeksiGabionanyam.mesin', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiGabionanyam', fn($g) => $g->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiGabionanyam', fn($g) => $g->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_gabionanyam_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiGabionanyam->tanggal,
                    'shift' => $fg->inspeksiGabionanyam->shift,
                    'nomor_inspeksi' => $fg->inspeksiGabionanyam->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiGabionanyam->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiGabionanyam->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiGabionanyam->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'Gabion Anyam',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_gabionanyam_fg.qrcode', $fg->id),
                ])
            : collect();

        $shearing = ($modul === '' || $modul === 'Shearing')
            ? InspeksiShearingFg::query()
                ->with('inspeksiShearing.pro', 'inspeksiShearing.mesin', 'details', 'user')
                ->whereIn('status', $statuses)
                ->when($startDate, fn($q) => $q->whereHas('inspeksiShearing', fn($s) => $s->whereDate('tanggal', '>=', $startDate)))
                ->when($endDate, fn($q) => $q->whereHas('inspeksiShearing', fn($s) => $s->whereDate('tanggal', '<=', $endDate)))
                ->get(['id', 'lot_number', 'status', 'qty', 'weight', 'user_id', 'inspeksi_shearing_id'])
                ->map(fn($fg) => [
                    'id' => $fg->id,
                    'lot_number' => $fg->lot_number,
                    'status' => $fg->status,
                    'qty' => $fg->qty,
                    ...$this->weightValues($fg),
                    'tanggal' => $fg->inspeksiShearing->tanggal,
                    'shift' => $fg->inspeksiShearing->shift,
                    'nomor_inspeksi' => $fg->inspeksiShearing->nomor_inspeksi,
                    'pro_number' => $fg->inspeksiShearing->pro->pro_id,
                    'kode_mesin' => $fg->inspeksiShearing->mesin?->mesin_id ?? '-',
                    'description' => $fg->inspeksiShearing->pro->description ?? '-',
                    'detail_inspeksi_1' => $this->detailValue($fg->details, 'description'),
                    'detail_inspeksi_2' => $this->detailValue($fg->details, 'description2'),
                    'modul' => 'Shearing',
                    'inspector' => $fg->user?->name ?? '-',
                    'qrcode_url' => route('inspeksi_shearing_fg.qrcode', $fg->id),
                ])
            : collect();

        $items = $wm
            ->concat($fencing)
            ->concat($ct)
            ->concat($chainlink)
            ->concat($kawatDuri)
            ->concat($razorPacking)
            ->concat($gabionPacking)
            ->concat($gabionAnyam)
            ->concat($shearing)
            ->filter(fn($item) => !empty($item['lot_number']));

        if ($search !== '') {
            $items = $items->filter(fn($item) => $this->matchesSearch($item, $search));
        }

        return $items->sortByDesc('lot_number')->values();
    }

    /**
     * Cek apakah item cocok dengan kata kunci pencarian.
     */
    private function matchesSearch(array $item, string $search): bool
    {
        $fields = [
            'lot_number',
            'nomor_inspeksi',
            'pro_number',
            'kode_mesin',
            'description',
            'detail_inspeksi_1',
            'detail_inspeksi_2',
        ];

        foreach ($fields as $field) {
            if (Str::contains((string) ($item[$field] ?? ''), $search, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Ambil field detail inspeksi pertama, fallback '-' bila tidak ada.
     */
    private function detailValue($details, string $field): string
    {
        $value = $details->first()?->{$field};

        return filled($value) ? $value : '-';
    }

    /**
     * Hitung weight dan total weight (qty x weight).
     */
    private function weightValues($fg): array
    {
        $weight = $fg->weight !== null ? (float) $fg->weight : null;

        return [
            'weight' => $weight,
            'total_weight' => $weight !== null
                ? round((float) $fg->qty * $weight, 2)
                : null,
        ];
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

    public function dashboard()
    {
        return view('daftar_ng_reject.dashboard', [
            'moduls' => self::MODULS,
            'statuses' => self::STATUSES,
        ]);
    }

    public function dashboardData(Request $request)
    {
        $filters = $this->dashboardFilters($request);
        $base = $this->dashboardBaseQuery($filters);

        $kpiRow = (clone $base)->selectRaw(
            "SUM(CASE WHEN status = 'NG' THEN 1 ELSE 0 END) as total_ng,
             SUM(CASE WHEN status = 'REJECT' THEN 1 ELSE 0 END) as total_reject,
             COALESCE(SUM(qty), 0) as total_qty,
             COALESCE(SUM(total_weight), 0) as total_weight"
        )->first();

        $trendRows = (clone $base)
            ->selectRaw(
                "tanggal,
                 SUM(CASE WHEN status = 'NG' THEN 1 ELSE 0 END) as ng_count,
                 SUM(CASE WHEN status = 'REJECT' THEN 1 ELSE 0 END) as reject_count"
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $topDefects = $this->topDefects($filters);
        $topProducts = $this->topByStatus('product_description', $filters);
        $topInspectors = $this->topByStatus('inspector', $filters);

        return response()->json([
            'kpi' => [
                'total_ng' => (int) ($kpiRow->total_ng ?? 0),
                'total_reject' => (int) ($kpiRow->total_reject ?? 0),
                'total_qty' => (float) ($kpiRow->total_qty ?? 0),
                'total_weight' => round((float) ($kpiRow->total_weight ?? 0), 2),
            ],
            'trend' => [
                'labels' => $trendRows->pluck('tanggal')->map(fn ($d) => (string) $d)->values(),
                'ng' => $trendRows->pluck('ng_count')->map(fn ($v) => (int) $v)->values(),
                'reject' => $trendRows->pluck('reject_count')->map(fn ($v) => (int) $v)->values(),
            ],
            'top_defects' => [
                'labels' => $topDefects->pluck('defect')->values(),
                'values' => $topDefects->pluck('total')->map(fn ($v) => (int) $v)->values(),
            ],
            'top_products' => $this->groupedPayload($topProducts),
            'top_inspectors' => $this->groupedPayload($topInspectors),
            'filters_applied' => $filters,
        ]);
    }

    private function dashboardFilters(Request $request): array
    {
        return [
            'start_date' => $this->parseDate($request->query('start_date')),
            'end_date' => $this->parseDate($request->query('end_date')),
            'status' => in_array($request->query('status'), self::STATUSES, true)
                ? $request->query('status')
                : '',
            'modul' => in_array($request->query('modul'), self::MODULS, true)
                ? $request->query('modul')
                : '',
            'defect' => trim((string) $request->query('defect', '')),
            'produk' => trim((string) $request->query('produk', '')),
            'inspector' => trim((string) $request->query('inspector', '')),
        ];
    }

    private function dashboardBaseQuery(array $filters)
    {
        $query = DB::table('vw_daftar_ng_reject');

        if (!empty($filters['start_date'])) {
            $query->whereDate('tanggal', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('tanggal', '<=', $filters['end_date']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['modul'])) {
            $query->where('source_module', $filters['modul']);
        }

        if (!empty($filters['defect'])) {
            $defect = $filters['defect'];
            $query->where(function ($q) use ($defect) {
                $q->where('detail_inspeksi_1', $defect)
                    ->orWhere('detail_inspeksi_2', $defect);
            });
        }

        if (!empty($filters['produk'])) {
            $query->where('product_description', $filters['produk']);
        }

        if (!empty($filters['inspector'])) {
            $query->where('inspector', $filters['inspector']);
        }

        return $query;
    }

    private function topDefects(array $filters, int $limit = 10)
    {
        $base1 = $this->dashboardBaseQuery($filters)
            ->whereNotNull('detail_inspeksi_1')
            ->where('detail_inspeksi_1', '<>', '')
            ->where('detail_inspeksi_1', '<>', '-')
            ->selectRaw('detail_inspeksi_1 as defect');

        $base2 = $this->dashboardBaseQuery($filters)
            ->whereNotNull('detail_inspeksi_2')
            ->where('detail_inspeksi_2', '<>', '')
            ->where('detail_inspeksi_2', '<>', '-')
            ->selectRaw('detail_inspeksi_2 as defect');

        $union = $base1->unionAll($base2);

        return DB::query()
            ->fromSub($union, 'defects')
            ->selectRaw('defect, COUNT(*) as total')
            ->groupBy('defect')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    /**
     * Top N berdasarkan kolom tertentu (mis. product_description / inspector)
     * dengan pemisahan jumlah NG dan REJECT.
     */
    private function topByStatus(string $column, array $filters, int $limit = 10)
    {
        return $this->dashboardBaseQuery($filters)
            ->whereNotNull($column)
            ->where($column, '<>', '')
            ->where($column, '<>', '-')
            ->selectRaw(
                "{$column} as label,
                 SUM(CASE WHEN status = 'NG' THEN 1 ELSE 0 END) as ng,
                 SUM(CASE WHEN status = 'REJECT' THEN 1 ELSE 0 END) as reject,
                 COUNT(*) as total"
            )
            ->groupBy($column)
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    /**
     * Ubah hasil query top N menjadi payload chart + tabel.
     */
    private function groupedPayload($rows): array
    {
        return [
            'labels' => $rows->pluck('label')->values(),
            'ng' => $rows->pluck('ng')->map(fn ($v) => (int) $v)->values(),
            'reject' => $rows->pluck('reject')->map(fn ($v) => (int) $v)->values(),
            'totals' => $rows->pluck('total')->map(fn ($v) => (int) $v)->values(),
            'rows' => $rows->map(fn ($row) => [
                'label' => $row->label,
                'ng' => (int) $row->ng,
                'reject' => (int) $row->reject,
                'total' => (int) $row->total,
            ])->values(),
        ];
    }
}
