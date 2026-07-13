<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspeksi_wm_fg_handlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_wm_fg_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->foreignId('user_id')->constrained();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wm_fg_handlings');
    }
};
