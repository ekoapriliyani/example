<?php

namespace App\Exports\Laporan;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Workbook "Laporan Incoming" - 4 sheet:
 *
 * 1. Laporan Incoming       : 1 baris per incoming + jumlah inspeksi/test (siap PivotTable)
 * 2. Detail Inspeksi        : 1 baris per data inspeksi (per koil)
 * 3. Detail Mechanical Test : 1 baris per data mechanical test
 * 4. Info                   : filter, ringkasan total, waktu & pembuat generate
 *
 * Kolom kunci "Tanggal" & "Nomor Inspeksi" ada di semua sheet data
 * agar mudah dicocokkan (XLOOKUP/Pivot) antar sheet.
 */
class LaporanIncomingWorkbook implements WithMultipleSheets
{
    public function __construct(
        private Builder $query,
        private ?string $startDate = null,
        private ?string $endDate = null,
        private array $totals = [],
        private ?string $generatedBy = null,
    ) {
    }

    public function sheets(): array
    {
        return [
            new IncomingMasterSheet($this->query),
            new IncomingInspeksiSheet($this->startDate, $this->endDate),
            new IncomingMechanicalSheet($this->startDate, $this->endDate),
            new LaporanInfoSheet($this->startDate, $this->endDate, $this->totals, $this->generatedBy),
        ];
    }
}
