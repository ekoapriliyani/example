<?php

namespace App\Console\Commands;

use App\Models\ProReference;
use App\Services\SybaseService;
use Illuminate\Console\Command;

class SyncProReference extends Command
{
    protected $signature = 'sync:pro-reference';
    protected $description = 'Sync trno dan description dari Sybase ke MySQL';

    public function handle(SybaseService $sybaseService)
    {
        try {
            $rows = $sybaseService->getProReferences();

            $total = 0;

            foreach ($rows as $row) {
                $trno = trim($row['trno'] ?? '');
                $description = trim($row['description'] ?? '');

                if ($trno === '' || $description === '') {
                    continue;
                }

                ProReference::updateOrCreate(
                    [
                        'trno' => $trno,
                        'description' => $description,
                    ],
                    [
                        'synced_at' => now(),
                    ]
                );

                $total++;
            }

            $this->info("Sync selesai. Total data diproses: {$total}");
        } catch (\Throwable $e) {
            $this->error('Sync gagal: ' . $e->getMessage());
        }

        return self::SUCCESS;
    }
}