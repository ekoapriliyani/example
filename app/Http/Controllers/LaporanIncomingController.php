<?php

namespace App\Http\Controllers;

use App\Exports\LaporanIncomingExport;
use App\Models\IncomingBahanBaku;
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
            ->paginate(10)
            ->withQueryString();

        return view('laporan.incoming', compact('data'));
    }

    /**
     * Export laporan ke Excel (.xlsx), mengikuti filter yang aktif di layar.
     */
    public function export(Request $request)
    {
        $filename = 'laporan-incoming_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new LaporanIncomingExport($this->filtered($request)),
            $filename
        );
    }

    /**
     * Query dasar laporan, dipakai bersama oleh index() dan export().
     *
     * Satu baris per incoming; data inspeksi & mechanical test di-eager-load
     * lalu digabung per kolom di tampilan/export (tanpa duplikasi baris).
     */
    private function filtered(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return IncomingBahanBaku::with([
            'supplier',
            'approver',
            'incomingbahanbakuinspeksi' => function ($query) {
                $query->orderBy('id');
            },
            'incomingbahanbakuinspeksi.user:id,name',
            'mechanicalTests' => function ($query) {
                $query->orderBy('id');
            },
            'mechanicalTests.user:id,name',
        ])
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('tanggal', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('tanggal', '<=', $endDate);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');
    }
}
