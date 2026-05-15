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
        Schema::create('product_razors', function (Blueprint $table) {
            $table->id();
            $table->string('product_razor_id');
            $table->string('description');
            $table->decimal('p_roll', 8, 2)->nullable();
            $table->decimal('tol_min_p_roll', 8, 2)->nullable();
            $table->decimal('tol_max_p_roll', 8, 2)->nullable();
            $table->decimal('d_spiral', 8, 2)->nullable();
            $table->decimal('tol_min_d_spiral', 8, 2)->nullable();
            $table->decimal('tol_max_d_spiral', 8, 2)->nullable();
            $table->decimal('d_kawat', 8, 2)->nullable();
            $table->decimal('tol_min_d_kawat', 8, 2)->nullable();
            $table->decimal('tol_max_d_kawat', 8, 2)->nullable();
            $table->decimal('tebal_blade', 8, 2)->nullable();
            $table->decimal('tol_min_tebal_blade', 8, 2)->nullable();
            $table->decimal('tol_max_tebal_blade', 8, 2)->nullable();
            $table->decimal('p_blade', 8, 2)->nullable();
            $table->decimal('tol_min_p_blade', 8, 2)->nullable();
            $table->decimal('tol_max_p_blade', 8, 2)->nullable();
            $table->decimal('l_blade', 8, 2)->nullable();
            $table->decimal('tol_min_l_blade', 8, 2)->nullable();
            $table->decimal('tol_max_l_blade', 8, 2)->nullable();
            $table->decimal('jarak_blade', 8, 2)->nullable();
            $table->decimal('tol_min_jarak_blade', 8, 2)->nullable();
            $table->decimal('tol_max_jarak_blade', 8, 2)->nullable();
            $table->decimal('jml_spiral', 8, 2)->nullable();
            $table->decimal('tol_min_jml_spiral', 8, 2)->nullable();
            $table->decimal('tol_max_jml_spiral', 8, 2)->nullable();
            $table->decimal('jml_klip_per_spiral', 8, 2)->nullable();
            $table->decimal('jarak_antar_klip', 8, 2)->nullable();
            $table->decimal('l_sheetgalvanized', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_razors');
    }
};
