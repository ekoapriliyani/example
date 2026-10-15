<?php

namespace App\Exports\Laporan;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Sheet 4 - "Info"
 * Metadata laporan: filter yang dipakai, ringkasan total baris, waktu & pembuat.
 * Filter tidak ditulis di atas sheet data agar tetap rapi untuk PivotTable.
 */
class LaporanInfoSheet implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
    WithColumnWidths,
    WithStyles,
    WithEvents,
    WithTitle
{
    use HasLaporanSheetFormatting;

    public function title(): string
    {
        return 'Info';
    }
    public function __construct(
        private ?string $startDate = null,
        private ?string $endDate = null,
        private array $totals = [],
        private ?string $generatedBy = null,
    ) {
    }

    public function collection()
    {
        return collect([
            ['Nama Laporan', 'Laporan Incoming Bahan Baku'],
            ['Rentang Tanggal Filter', $this->dateRangeLabel()],
            ['Total Incoming', (int) ($this->totals['incoming'] ?? 0)],
            ['Total Data Inspeksi', (int) ($this->totals['inspeksi'] ?? 0)],
            ['Total Data Mechanical Test', (int) ($this->totals['mechanical'] ?? 0)],
            ['Digenerate Pada', now()->format('d/m/Y H:i:s')],
            ['Digenerate Oleh', $this->generatedBy ?? '-'],
        ]);
    }

    public function headings(): array
    {
        return ['Parameter', 'Nilai'];
    }

    public function map($row): array
    {
        return [
            $row[0] ?? '',
            $row[1] ?? '',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 45,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F0F0F0'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                    ],
                ],
            ],
        ];
    }

    private function dateRangeLabel(): string
    {
        if ($this->startDate && $this->endDate) {
            return "{$this->startDate} s/d {$this->endDate}";
        }

        if ($this->startDate) {
            return "Mulai {$this->startDate}";
        }

        if ($this->endDate) {
            return "Sampai {$this->endDate}";
        }

        return 'Semua data';
    }
}
