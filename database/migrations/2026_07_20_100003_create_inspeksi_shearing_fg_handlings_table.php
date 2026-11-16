<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspeksi_shearing_fg_handlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_shearing_fg_id')
                ->constrained('inspeksi_shearing_fgs')
                ->cascadeOnDelete()
                ->name('fk_shearing_fg_handlings');
            $table->date('tanggal');
            $table->foreignId('user_id')->constrained();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_shearing_fg_handlings');
    }
};
