<?php

namespace App\Exports;

use App\Support\LaporanFormatter;
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

class LaporanIncomingExport implements
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
            // Incoming
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

            // Ringkasan
            'Jumlah Inspeksi',
            'Jumlah Mechanical Test',

            // Inspeksi (digabung)
            'No Koil (Inspeksi)',
            'D1',
            'D2',
            'D3',
            'Rata-rata',
            'Dimensi',
            'Visual',
            'Description 1 (Inspeksi)',
            'Description 2 (Inspeksi)',
            'Lot Number (Inspeksi)',
            'Inspeksi Oleh',

            // Mechanical Test (digabung)
            'Nomor Koil (Mech Test)',
            'Hasil Tensile',
            'Hasil Coating Weight',
            'Hasil Lilit',
            'Hasil Puntir',
            'Status (Mech Test)',
            'Description 1 (Mech Test)',
            'Description 2 (Mech Test)',
            'Lot Number (Mech Test)',
            'Mechanical Test Oleh',
        ];
    }

    public function map($row): array
    {
        $inspeksi = $row->incomingbahanbakuinspeksi;
        $mechanical = $row->mechanicalTests;

        return [
            // Incoming
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
            $row->approver->name ?? '',
            $row->approved_at ? Carbon::parse($row->approved_at)->format('d/m/Y H:i') : '',
            $row->created_at ? $row->created_at->format('d/m/Y H:i') : '',

            // Ringkasan
            $inspeksi->count(),
            $mechanical->count(),

            // Inspeksi (digabung per kolom, null/kosong dilewati)
            LaporanFormatter::joinValues($inspeksi, 'no_koil'),
            LaporanFormatter::joinValues($inspeksi, 'd1'),
            LaporanFormatter::joinValues($inspeksi, 'd2'),
            LaporanFormatter::joinValues($inspeksi, 'd3'),
            LaporanFormatter::joinValues($inspeksi, 'rata_rata'),
            LaporanFormatter::joinValues($inspeksi, 'dimensi'),
            LaporanFormatter::joinValues($inspeksi, 'visual'),
            LaporanFormatter::joinValues($inspeksi, 'description1'),
            LaporanFormatter::joinValues($inspeksi, 'description2'),
            LaporanFormatter::joinValues($inspeksi, 'lot_number'),
            LaporanFormatter::joinValues($inspeksi->pluck('user')->filter(), 'name'),

            // Mechanical Test (digabung per kolom)
            LaporanFormatter::joinValues($mechanical, 'nomor_koil'),
            LaporanFormatter::joinValues($mechanical, 'hasil_tensile'),
            LaporanFormatter::joinValues($mechanical, 'hasil_coatingweight'),
            LaporanFormatter::joinValues($mechanical, 'hasil_lilit'),
            LaporanFormatter::joinValues($mechanical, 'hasil_puntir'),
            LaporanFormatter::joinValues($mechanical, 'status'),
            LaporanFormatter::joinValues($mechanical, 'description1'),
            LaporanFormatter::joinValues($mechanical, 'description2'),
            LaporanFormatter::joinValues($mechanical, 'lot_number'),
            LaporanFormatter::joinValues($mechanical->pluck('user')->filter(), 'name'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,  // Tanggal
            'B' => 13,  // Jenis
            'C' => 22,  // Nomor Inspeksi
            'D' => 16,  // No RCR
            'E' => 32,  // Description
            'F' => 28,  // Supplier
            'G' => 18,  // No PO
            'H' => 18,  // No SJ
            'I' => 10,  // Jml Koil
            'J' => 10,  // D Kawat
            'K' => 10,  // Tol
            'L' => 16,  // Jenis Kawat
            'M' => 16,  // Certificate
            'N' => 14,  // Status Approval
            'O' => 18,  // Approved By
            'P' => 17,  // Approved At
            'Q' => 17,  // Created At
            'R' => 12,  // Jumlah Inspeksi
            'S' => 16,  // Jumlah Mechanical Test
            'T' => 24,  // No Koil (Inspeksi)
            'U' => 16,  // D1
            'V' => 16,  // D2
            'W' => 16,  // D3
            'X' => 16,  // Rata-rata
            'Y' => 18,  // Dimensi
            'Z' => 18,  // Visual
            'AA' => 30, // Description 1 (Inspeksi)
            'AB' => 30, // Description 2 (Inspeksi)
            'AC' => 24, // Lot Number (Inspeksi)
            'AD' => 20, // Inspeksi Oleh
            'AE' => 24, // Nomor Koil (Mech Test)
            'AF' => 18, // Hasil Tensile
            'AG' => 20, // Hasil Coating Weight
            'AH' => 16, // Hasil Lilit
            'AI' => 16, // Hasil Puntir
            'AJ' => 18, // Status (Mech Test)
            'AK' => 30, // Description 1 (Mech Test)
            'AL' => 30, // Description 2 (Mech Test)
            'AM' => 24, // Lot Number (Mech Test)
            'AN' => 22, // Mechanical Test Oleh
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
                    'wrapText' => true,
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
