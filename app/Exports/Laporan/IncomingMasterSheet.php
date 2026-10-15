<?php

namespace App\Exports\Laporan;

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
 * Sheet 1 - "Laporan Incoming"
 * Grain: 1 baris = 1 incoming bahan baku (+ ringkasan jumlah) -> siap PivotTable.
 */
class IncomingMasterSheet implements
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
        return 'Laporan Incoming';
    }

    public function __construct(private Builder $query)
    {
    }

    public function query(): Builder
    {
        return clone $this->query;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis',
            'Nomor Inspeksi',
            'No RCR',
            'Description / Nama Barang',
            'Supplier',
            'No PO',
            'No SJ',
            'Jml Koil',
            'D Kawat',
            'Tol Kawat',
            'Jenis Kawat',
            'Certificate',
            'Status Approval',
            'Approved By',
            'Approved At',
            'Created At',
            'Jumlah Inspeksi',
            'Jumlah Mechanical Test',
        ];
    }

    public function map($row): array
    {
        return [
            // Sel date asli (serial Excel; diformat DD/MM/YYYY oleh event AfterSheet)
            $this->excelDate($row->tanggal),
            $row->jenis === 'non_reguler' ? 'Non Reguler' : 'Reguler',
            $row->nomor_inspeksi,
            $row->no_rcr,
            $row->description,
            $row->supplier->nama ?? '',
            $row->no_po,
            $row->no_sj,
            $this->num($row->jml_koil),
            $this->num($row->d_kawat),
            $this->num($row->tol),
            $row->jenis_kawat,
            $row->certificate,
            $row->isApproved() ? 'Approved' : 'Pending',
            $row->approver->name ?? '',
            $this->excelDate($row->approved_at),
            $this->excelDate($row->created_at),
            (int) ($row->incomingbahanbakuinspeksi_count ?? 0),
            (int) ($row->mechanical_tests_count ?? $row->mechanicalTests_count ?? 0),
        ];
    }

    public function dateColumns(): array
    {
        return ['A'];
    }

    public function dateTimeColumns(): array
    {
        return ['P', 'Q'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // Tanggal
            'B' => 13, // Jenis
            'C' => 22, // Nomor Inspeksi
            'D' => 16, // No RCR
            'E' => 32, // Description
            'F' => 28, // Supplier
            'G' => 18, // No PO
            'H' => 18, // No SJ
            'I' => 10, // Jml Koil
            'J' => 10, // D Kawat
            'K' => 10, // Tol
            'L' => 16, // Jenis Kawat
            'M' => 16, // Certificate
            'N' => 14, // Status Approval
            'O' => 18, // Approved By
            'P' => 17, // Approved At
            'Q' => 17, // Created At
            'R' => 14, // Jumlah Inspeksi
            'S' => 20, // Jumlah Mechanical Test
        ];
    }
}
