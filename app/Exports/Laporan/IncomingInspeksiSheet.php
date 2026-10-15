<?php

namespace App\Exports\Laporan;

use App\Models\IncomingBahanBakuInspeksi;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

/**
 * Sheet 2 - "Detail Inspeksi"
 * Grain: 1 baris = 1 data inspeksi (per koil), tanpa digabung koma.
 * Kolom kunci relasi (Tanggal, Nomor Inspeksi, Supplier, No PO, No SJ)
 * disertakan agar mudah dicocokkan dengan Sheet 1.
 */
class IncomingInspeksiSheet implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
    WithColumnWidths,
    WithTitle,
    WithStyles,
    WithEvents
{
    use HasLaporanSheetFormatting;

    public function title(): string
    {
        return 'Detail Inspeksi';
    }

    public function __construct(
        private ?string $startDate = null,
        private ?string $endDate = null,
    ) {
    }

    public function query(): Builder
    {
        return IncomingBahanBakuInspeksi::query()
            ->with(['incomingbahanbaku.supplier', 'user:id,name'])
            ->when($this->startDate, function ($query, $startDate) {
                return $query->whereHas('incomingbahanbaku', function ($q) use ($startDate) {
                    $q->whereDate('tanggal', '>=', $startDate);
                });
            })
            ->when($this->endDate, function ($query, $endDate) {
                return $query->whereHas('incomingbahanbaku', function ($q) use ($endDate) {
                    $q->whereDate('tanggal', '<=', $endDate);
                });
            })
            ->orderBy('incoming_bahan_baku_id')
            ->orderBy('id');
    }

    public function headings(): array
    {
        return [
            // Kolom kunci relasi (untuk mencocokkan ke Sheet 1)
            'Tanggal',
            'Nomor Inspeksi',
            'Supplier',
            'No PO',
            'No SJ',

            // Detail inspeksi
            'No Koil',
            'D1',
            'D2',
            'D3',
            'Rata-rata',
            'Dimensi',
            'Visual',
            'Description 1',
            'Description 2',
            'Lot Number',
            'Inspeksi Oleh',
            'Created At',
        ];
    }

    public function map($row): array
    {
        $ibb = $row->incomingbahanbaku;

        return [
            // Kolom kunci relasi
            $this->excelDate($ibb?->tanggal),
            $ibb->nomor_inspeksi ?? '',
            $ibb->supplier->nama ?? '',
            $ibb->no_po ?? '',
            $ibb->no_sj ?? '',

            // Detail inspeksi (angka -> numerik asli)
            $row->no_koil,
            $this->num($row->d1),
            $this->num($row->d2),
            $this->num($row->d3),
            $this->num($row->rata_rata),
            $row->dimensi,
            $row->visual,
            $row->description1,
            $row->description2,
            $row->lot_number,
            $row->user->name ?? '',
            $this->excelDate($row->created_at),
        ];
    }

    public function dateColumns(): array
    {
        return ['A'];
    }

    public function dateTimeColumns(): array
    {
        return ['Q'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // Tanggal
            'B' => 22, // Nomor Inspeksi
            'C' => 28, // Supplier
            'D' => 18, // No PO
            'E' => 18, // No SJ
            'F' => 16, // No Koil
            'G' => 10, // D1
            'H' => 10, // D2
            'I' => 10, // D3
            'J' => 12, // Rata-rata
            'K' => 16, // Dimensi
            'L' => 16, // Visual
            'M' => 30, // Description 1
            'N' => 30, // Description 2
            'O' => 24, // Lot Number
            'P' => 20, // Inspeksi Oleh
            'Q' => 17, // Created At
        ];
    }
}
