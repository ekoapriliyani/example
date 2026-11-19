<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarNgRejectExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
    WithColumnWidths,
    WithStyles
{
    private int $rowNumber = 0;

    public function __construct(private Collection $items)
    {
    }

    public function collection(): Collection
    {
        $this->rowNumber = 0;

        return $this->items->values();
    }

    public function headings(): array
    {
        return [
            'No',
            'Status',
            'No Inspeksi',
            'Tanggal',
            'Shift',
            'PRO Number',
            'Kode Mesin',
            'Description (Nama Produk)',
            'Qty',
            'Weight',
            'Total Weight',
            'Detail Inspeksi 1',
            'Detail Inspeksi 2',
            'Modul',
            'Lot Number',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row['status'] ?? '',
            $row['nomor_inspeksi'] ?? '',
            $row['tanggal'] ?? '',
            $row['shift'] ?? '',
            $row['pro_number'] ?? '',
            $row['kode_mesin'] ?? '-',
            $row['description'] ?? '-',
            $row['qty'] ?? 0,
            $row['weight'],
            $row['total_weight'],
            $row['detail_inspeksi_1'] ?? '-',
            $row['detail_inspeksi_2'] ?? '-',
            $row['modul'] ?? '',
            $row['lot_number'] ?? '',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 10,
            'C' => 20,
            'D' => 12,
            'E' => 7,
            'F' => 20,
            'G' => 12,
            'H' => 40,
            'I' => 8,
            'J' => 10,
            'K' => 12,
            'L' => 28,
            'M' => 28,
            'N' => 15,
            'O' => 22,
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
