<?php

namespace App\Console\Commands;

use App\Models\Pro;
use App\Services\SybaseService;
use Illuminate\Console\Command;

class SyncProReference extends Command
{
    protected $signature = 'sync:pro-reference';
    protected $description = 'Sync data PRO dari Sybase ke MySQL';

    public function handle(SybaseService $sybaseService)
    {
        try {
            $rows = $sybaseService->getAllProData();

            $total = 0;

            foreach ($rows as $row) {
                $trno = $this->cleanText($row['trno'] ?? '');
                $description = $this->cleanText($row['description'] ?? '');
                $qty = $row['Qty_ordered'] ?? $row['qty_ordered'] ?? null;

                if ($trno === '') {
                    continue;
                }

                Pro::updateOrCreate(
                    ['pro_id' => $trno],
                    [
                        'description' => $description,
                        'qty' => $qty,
                    ]
                );

                $total++;
            }

            $this->info("Sync selesai. Total data: {$total}");
        } catch (\Throwable $e) {
            $this->error('Sync gagal: ' . $e->getMessage());
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