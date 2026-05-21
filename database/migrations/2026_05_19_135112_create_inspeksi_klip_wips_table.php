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
        Schema::create('inspeksi_klip_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_klip_id')->constrained('inspeksi_klips')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator')->nullable();
            $table->decimal('jml_klip', 8, 2)->nullable();
            $table->decimal('d_razor', 8, 2)->nullable();
            $table->decimal('jml_spiral', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip1', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip2', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip3', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip4', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip5', 8, 2)->nullable();
            $table->string('kerapatan')->nullable();
            $table->string('visual')->nullable();
            $table->string('status');
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_klip_wips');
    }
};
