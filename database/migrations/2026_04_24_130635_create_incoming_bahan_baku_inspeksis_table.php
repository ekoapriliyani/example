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
        Schema::create('incoming_bahan_baku_inspeksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_bahan_baku_id')->constrained('incoming_bahan_bakus')->onDelete('cascade');
            $table->decimal('diameter', 8,2)->nullable();
            $table->string('no_koil');
            $table->decimal('d1', 8,2)->nullable();
            $table->decimal('d2', 8,2)->nullable();
            $table->decimal('d3', 8,2)->nullable();
            $table->string('dimensi');
            $table->string('visual');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_bahan_baku_inspeksis');
    }
};
