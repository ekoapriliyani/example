<?php

namespace App\Console\Commands;

use App\Models\Shipment; // <-- Pastikan nama Model target Anda sudah benar di sini
use App\Services\SybaseService;
use Illuminate\Console\Command;

class SyncShipmentReference extends Command
{
    protected $signature = 'sync:shipment-reference';
    protected $description = 'Sync data Shipment dari Sybase ke MySQL';

    public function handle(SybaseService $sybaseService)
    {
        try {
            $this->info('Memulai sync data shipment...');

            // Memanggil fungsi baru yang sudah kita tes di Tinker tadi
            $rows = $sybaseService->getShipmentData();

            $total = 0;

            foreach ($rows as $row) {
                $trno = $this->cleanText($row['trno'] ?? '');
                $custname = $this->cleanText($row['custname'] ?? '');
                $description = $this->cleanText($row['description'] ?? '');
                $qty = $row['qt'] ?? $row['QT'] ?? null; // Menyesuaikan kolom 'qt' dari hasil tes Tinker

                if ($trno === '') {
                    continue;
                }

                // Melakukan upsert ke tabel MySQL berdasarkan trno (shipment_id)
                Shipment::updateOrCreate(
                    ['shipment_id' => $trno], // <-- Sesuaikan nama primary key/unique key di tabel MySQL Anda
                    [
                        'custname' => $custname,
                        'description' => $description,
                        'qty' => $qty,
                    ]
                );

                $total++;
            }

            $this->info("Sync selesai. Total data shipment: {$total}");
        } catch (\Throwable $e) {
            $this->error('Sync shipment gagal: ' . $e->getMessage());
        }

        return self::SUCCESS;
    }

    private function cleanText($value): string
    {
        if ($value === null) {
            return '';
        }

        $value = (string) $value;

        // non-breaking space dan karakter aneh dari ODBC/Sybase
        $value = str_replace("\xC2\xA0", ' ', $value);
        $value = str_replace("\xA0", ' ', $value);

        // buang karakter kontrol
        $value = preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value);

        // rapikan whitespace
        $value = preg_replace('/\s+/u', ' ', $value);

        return trim($value);
    }
}
