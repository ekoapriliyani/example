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
        Schema::create('inspeksi_fencing_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_fencing_id')->constrained('inspeksi_fencings')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('no_material');
            $table->string('nama_operator');
            $table->decimal('d_kawat_act', 8, 2)->nullable();
            $table->decimal('p_product_act', 8, 2)->nullable();
            $table->decimal('l_product_act', 8, 2)->nullable();
            $table->decimal('t_product_act', 8, 2)->nullable();
            $table->decimal('mesh1', 8, 2)->nullable();
            $table->decimal('mesh2', 8, 2)->nullable();
            $table->decimal('mesh3', 8, 2)->nullable();
            $table->decimal('mesh4', 8, 2)->nullable();
            $table->decimal('mesh5', 8, 2)->nullable();
            $table->decimal('mesh6', 8, 2)->nullable();
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
        Schema::dropIfExists('inspeksi_fencing_wips');
    }
};
