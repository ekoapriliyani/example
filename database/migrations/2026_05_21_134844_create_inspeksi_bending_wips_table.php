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
        Schema::create('inspeksi_bending_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_bending_id')->constrained('inspeksi_bendings')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('no_material');
            $table->string('nama_operator');
            $table->decimal('d_kawat_act', 8, 2)->nullable();
            $table->decimal('p_product_act', 8, 2)->nullable();
            $table->decimal('l_product_act', 8, 2)->nullable();
            $table->decimal('t_tekukan', 8, 2)->nullable();
            $table->decimal('sudut', 8, 2)->nullable();
            $table->decimal('diagonal', 8, 2)->nullable();
            $table->string('matchingcrosswire')->nullable();
            $table->string('visual')->nullable();
            $table->string('status')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_bending_wips');
    }
};
