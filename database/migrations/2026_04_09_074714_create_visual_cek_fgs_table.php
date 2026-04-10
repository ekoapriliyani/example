<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visual_cek_fgs', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->string('keterangan');
            $table->foreignId('inspeksi_wm_fg')->constrained('inspeksi_wm_fgs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visual_cek_fgs');
    }
};
