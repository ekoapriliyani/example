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
        Schema::create('incoming_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('no_po');
            $table->string('no_sj');
            $table->integer('jml_koil');
            $table->decimal('d_kawat', 8,2)->nullable();
            $table->decimal('tol', 8,2)->nullable();
            $table->string('jenis_kawat');
            $table->time('mulai');
            $table->time('selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_bahan_bakus');
    }
};
