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
        Schema::create('sheet_galvanizes', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inspeksi');
            $table->date('tanggal');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('no_po');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheet_galvanizes');
    }
};
