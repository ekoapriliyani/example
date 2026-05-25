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
        Schema::create('inspeksi_wf_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_wf_id')->constrained('inspeksi_wfs')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('no_material');
            $table->string('nama_operator');
            $table->decimal('d_kawat_act', 8, 2)->nullable();
            $table->decimal('p_product_act', 8, 2)->nullable();
            $table->string('visual')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wf_wips');
    }
};
