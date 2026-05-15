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
        Schema::create('temperatur_pvcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_pvc_id')->constrained('inspeksi_pvcs')->onDelete('cascade');
            $table->decimal('cs1', 8, 2)->nullable();
            $table->decimal('ca1', 8, 2)->nullable();
            $table->decimal('cs2', 8, 2)->nullable();
            $table->decimal('ca2', 8, 2)->nullable();
            $table->decimal('cs3', 8, 2)->nullable();
            $table->decimal('ca3', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperatur_pvcs');
    }
};
