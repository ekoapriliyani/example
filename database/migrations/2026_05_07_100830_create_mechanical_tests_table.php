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
        Schema::create('mechanical_tests', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_koil')->nullable();
            $table->foreignId('incoming_bahan_baku_id')->constrained('incoming_bahan_bakus')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('hasil_tensile', 8, 2)->nullable();
            $table->decimal('hasil_coatingweight', 8, 2)->nullable();
            $table->string('hasil_lilit')->nullable();
            $table->string('hasil_puntir')->nullable();
            $table->string('status')->nullable();
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_tests');
    }
};
