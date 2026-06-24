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
        Schema::create('inspeksi_pvc_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_pvc_id')->constrained('inspeksi_pvcs')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material');
            $table->string('nama_operator');
            $table->decimal('c1', 8, 2)->nullable();
            $table->decimal('c2', 8, 2)->nullable();
            $table->decimal('c3', 8, 2)->nullable();
            $table->decimal('c4', 8, 2)->nullable();
            $table->decimal('ch', 8, 2)->nullable();
            $table->decimal('d_kawat_inti', 8, 2)->nullable();
            $table->decimal('d_kawat_pvc', 8, 2)->nullable();
            $table->decimal('penyimpangan', 8, 2)->nullable();
            $table->string('warna');
            $table->string('uji_lilit');
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
        Schema::dropIfExists('inspeksi_pvc_wips');
    }
};
