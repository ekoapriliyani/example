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
        Schema::create('inspeksi_ct_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_ct_id')->constrained('inspeksi_cts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator')->nullable();
            $table->string('d_kawat_act')->nullable();
            $table->decimal('p_produk', 8, 2)->nullable();
            $table->decimal('l_produk', 8, 2)->nullable();
            $table->decimal('t_produk', 8, 2)->nullable();
            $table->decimal('mesh1', 8, 2)->nullable();
            $table->decimal('mesh2', 8, 2)->nullable();
            $table->decimal('mesh3', 8, 2)->nullable();
            $table->decimal('mesh4', 8, 2)->nullable();
            $table->decimal('mesh5', 8, 2)->nullable();
            $table->decimal('diagonal', 8, 2)->nullable();
            $table->string('visual');
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
        Schema::dropIfExists('inspeksi_ct_wips');
    }
};
