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
        Schema::create('inspeksi_bending_fg_details', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel utama
            $table->foreignId('inspeksi_bending_fg_id')->constrained('inspeksi_bending_fgs')->onDelete('cascade');
            // field detail
            $table->string('description')->nullable();
            $table->string('description2')->nullable();
            $table->integer('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_bending_fg_details');
    }
};
