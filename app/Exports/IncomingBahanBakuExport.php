<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomingBahanBakuExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
    WithColumnWidths,
    WithStyles
{
    public function __construct(private Builder $query)
    {
    }

    /**
     * Clone builder agar setiap chunk memakai instance segar,
     * sehingga forPage() tidak saling menimpa offset/limit.
     */
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
            'Status',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->tanggal ? Carbon::parse($row->tanggal)->format('d/m/Y') : '',
            $row->jenis === 'non_reguler' ? 'Non Reguler' : 'Reguler',
            $row->nomor_inspeksi,
            $row->no_rcr,
            $row->description,
            $row->supplier->nama ?? 'N/A',
            $row->no_po,
            $row->no_sj,
            $row->jml_koil,
            $row->d_kawat,
            $row->tol,
            $row->jenis_kawat,
            $row->certificate,
            $row->isApproved() ? 'Approved' : 'Pending',
            $row->created_at ? $row->created_at->format('d/m/Y H:i') : '',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 13,
            'C' => 22,
            'D' => 18,
            'E' => 32,
            'F' => 28,
            'G' => 18,
            'H' => 18,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 16,
            'M' => 16,
            'N' => 11,
            'O' => 17,
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
}
