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
        Schema::create('inspeksi_wm_fg_details', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel utama
            $table->foreignId('inspeksi_wm_fg_id')->constrained('inspeksi_wm_fgs')->onDelete('cascade');

            // field detail
            $table->string('name');          // misalnya "Tipis", "Melepuh"
            $table->text('description')->nullable(); // remark tambahan

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wm_fg_details');
    }
};
