<?php

namespace App\Exports\Laporan;

use App\Models\MechanicalTest;
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
 * Sheet 3 - "Detail Mechanical Test"
 * Grain: 1 baris = 1 data mechanical test, tanpa digabung koma.
 * Kolom kunci relasi disertakan agar mudah dicocokkan dengan Sheet 1.
 */
class IncomingMechanicalSheet implements
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
        return 'Detail Mechanical Test';
    }

    public function __construct(
        private ?string $startDate = null,
        private ?string $endDate = null,
    ) {
    }

    public function query(): Builder
    {
        return MechanicalTest::query()
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

            // Detail mechanical test
            'Nomor Koil',
            'Hasil Tensile',
            'Hasil Coating Weight',
            'Hasil Lilit',
            'Hasil Puntir',
            'Status',
            'Description 1',
            'Description 2',
            'Lot Number',
            'Mechanical Test Oleh',
            'Created At',
        ];
    }

    public function map($row): array
    {
        $ibb = $row->incomingBahanBaku;

        return [
            // Kolom kunci relasi
            $this->excelDate($ibb?->tanggal),
            $ibb->nomor_inspeksi ?? '',
            $ibb->supplier->nama ?? '',
            $ibb->no_po ?? '',

            // Detail mechanical test (angka -> numerik asli)
            $row->nomor_koil,
            $this->num($row->hasil_tensile),
            $this->num($row->hasil_coatingweight),
            $this->num($row->hasil_lilit),
            $this->num($row->hasil_puntir),
            $row->status,
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
        return ['O'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // Tanggal
            'B' => 22, // Nomor Inspeksi
            'C' => 28, // Supplier
            'D' => 18, // No PO
            'E' => 16, // Nomor Koil
            'F' => 14, // Hasil Tensile
            'G' => 20, // Hasil Coating Weight
            'H' => 14, // Hasil Lilit
            'I' => 14, // Hasil Puntir
            'J' => 12, // Status
            'K' => 30, // Description 1
            'L' => 30, // Description 2
            'M' => 24, // Lot Number
            'N' => 22, // Mechanical Test Oleh
            'O' => 17, // Created At
        ];
    }
}
