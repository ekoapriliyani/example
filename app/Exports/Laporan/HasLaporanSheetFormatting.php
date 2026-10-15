<?php

namespace App\Exports\Laporan;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Format standar untuk sheet laporan:
 * - Freeze pane baris 1 (header selalu terlihat)
 * - AutoFilter aktif di baris header
 * - Kolom tanggal ditulis sebagai sel date asli (DD/MM/YYYY), bukan teks
 * - Kolom tanggal+waktu memakai DD/MM/YYYY HH:MM
 * - Header bold, abu-abu, border tipis (tanpa merged cell)
 */
trait HasLaporanSheetFormatting
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestDataRow();
                $lastCol = $sheet->getHighestColumn();

                // Header tetap terlihat saat scroll
                $sheet->freezePane('A2');

                // Filter Excel aktif pada baris header
                if ($lastCol !== null) {
                    $sheet->setAutoFilter('A1:' . $lastCol . '1');
                }

                // Hanya format baris data (minimal ada 1 baris data)
                if ($lastRow >= 2) {
                    foreach ($this->dateColumns() as $col) {
                        $sheet->getStyle($col . '2:' . $col . $lastRow)
                            ->getNumberFormat()
                            ->setFormatCode('DD/MM/YYYY');
                    }

                    foreach ($this->dateTimeColumns() as $col) {
                        $sheet->getStyle($col . '2:' . $col . $lastRow)
                            ->getNumberFormat()
                            ->setFormatCode('DD/MM/YYYY HH:MM');
                    }
                }
            },
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

    /**
     * Huruf kolom tanggal (sel date asli DD/MM/YYYY).
     *
     * @return string[]
     */
    public function dateColumns(): array
    {
        return [];
    }

    /**
     * Huruf kolom tanggal + waktu (DD/MM/YYYY HH:MM).
     *
     * @return string[]
     */
    public function dateTimeColumns(): array
    {
        return [];
    }

    /**
     * Kembalikan nilai numerik asli jika memang angka (agar bisa di-SUM/pivot),
     * selain itu biarkan sebagai teks. Null/kosong -> sel kosong.
     */
    protected function num(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return '';
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        return $value;
    }

    /**
     * Ubah tanggal/waktu menjadi serial Excel asli (bukan teks),
     * agar sel jadi date cell yang bisa diformat, diurutkan, dan dipivot.
     * Null/kosong -> sel kosong.
     */
    protected function excelDate(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return '';
        }

        return Date::dateTimeToExcel(
            $value instanceof \DateTimeInterface ? $value : Carbon::parse($value)
        );
    }
}
