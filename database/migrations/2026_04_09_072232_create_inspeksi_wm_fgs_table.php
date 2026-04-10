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
        Schema::create('inspeksi_wm_fgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_wm_id')->constrained('inspeksi_wms')->onDelete('cascade'); // relasi ke header
            $table->string('batch_number');
            $table->string('status');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wm_fgs');
    }
};
