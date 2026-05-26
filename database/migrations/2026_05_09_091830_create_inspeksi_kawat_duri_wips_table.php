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
        Schema::create('inspeksi_kawat_duri_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_kawat_duri_id')->constrained('inspeksi_kawat_duris')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator');
            $table->decimal('d_inti_kd', 8, 2)->nullable();
            $table->decimal('d_pvc_kd', 8, 2)->nullable();
            $table->decimal('d_inti_kj', 8, 2)->nullable();
            $table->decimal('d_pvc_kj', 8, 2)->nullable();
            $table->decimal('jarak_duri', 8, 2)->nullable();
            $table->decimal('jml_jalinan_duri', 8, 2)->nullable();
            $table->decimal('sudut_ujung_duri', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('jml_counter', 8, 2)->nullable();
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
        Schema::dropIfExists('inspeksi_kawat_duri_wips');
    }
};
