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
        Schema::create('inspeksi_wm_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_wm_id')->constrained('inspeksi_wms')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('no_material');
            $table->string('nama_operator');
            $table->decimal('d_kawat_act', 8,2);
            $table->decimal('p_product_act', 8,2);
            $table->decimal('l_product_act', 8,2);
            $table->decimal('p_mesh_act', 8,2);
            $table->decimal('l_mesh_act', 8,2);
            $table->decimal('selisih_diagonal', 8,2);
            $table->string('status_dimensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wm_wips');
    }
};
