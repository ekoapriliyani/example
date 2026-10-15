<?php

namespace App\Http\Controllers;

use App\Exports\Laporan\LaporanIncomingWorkbook;
use App\Models\IncomingBahanBaku;
use App\Models\IncomingBahanBakuInspeksi;
use App\Models\MechanicalTest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanIncomingController extends Controller
{
    /**
     * Tampilkan laporan incoming bahan baku (1 baris per incoming)
     * dengan filter range tanggal.
     */
    public function index(Request $request)
    {
        $data = $this->filtered($request)
            ->with([
                'incomingbahanbakuinspeksi' => function ($query) {
                    $query->orderBy('id');
                },
                'incomingbahanbakuinspeksi.user:id,name',
                'mechanicalTests' => function ($query) {
                    $query->orderBy('id');
                },
                'mechanicalTests.user:id,name',
            ])
            ->paginate(10)
            ->withQueryString();

        return view('laporan.incoming', compact('data'));
    }

    /**
     * Export laporan ke Excel multi-sheet, mengikuti filter yang aktif di layar:
     *
     * 1. Laporan Incoming       -> 1 baris per incoming + ringkasan jumlah (siap PivotTable)
     * 2. Detail Inspeksi        -> 1 baris per data inspeksi (per koil)
     * 3. Detail Mechanical Test -> 1 baris per data mechanical test
     * 4. Info                   -> filter, total baris, waktu & pembuat generate
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $totals = [
            'incoming' => (clone $this->filtered($request))->count(),
            'inspeksi' => IncomingBahanBakuInspeksi::whereHas(
                'incomingbahanbaku',
                $this->dateFilter($startDate, $endDate)
            )->count(),
            'mechanical' => MechanicalTest::whereHas(
                'incomingbahanbaku',
                $this->dateFilter($startDate, $endDate)
            )->count(),
        ];

        $query = $this->filtered($request)
            ->withCount(['incomingbahanbakuinspeksi', 'mechanicalTests']);

        $filename = sprintf(
            'laporan-incoming_%s_%s.xlsx',
            $startDate ?: 'semua',
            $endDate ?: 'semua'
        );

        return Excel::download(
            new LaporanIncomingWorkbook($query, $startDate, $endDate, $totals, auth()->user()?->name ?? $request->user()?->name),
            $filename
        );
    }

    /**
     * Query dasar laporan (1 baris per incoming), dipakai bersama oleh index() dan export().
     *
     * Kolom child (inspeksi & mechanical test) tidak di-join di sini:
     * - untuk layar: di-eager-load di index() lalu digabung per kolom
     * - untuk Excel: dipecah jadi sheet detail terpisah di export()
     */
    private function filtered(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return IncomingBahanBaku::with(['supplier', 'approver'])
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('tanggal', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('tanggal', '<=', $endDate);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * Filter range tanggal pada kolom incoming.tanggal (untuk query child).
     */
    private function dateFilter(?string $startDate, ?string $endDate): \Closure
    {
        return function ($query) use ($startDate, $endDate) {
            $query->when($startDate, function ($q, $startDate) {
                return $q->whereDate('tanggal', '>=', $startDate);
            })->when($endDate, function ($q, $endDate) {
                return $q->whereDate('tanggal', '<=', $endDate);
            });
        };
    }
}
