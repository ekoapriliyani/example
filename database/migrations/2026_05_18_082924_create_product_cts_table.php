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
        Schema::create('product_cts', function (Blueprint $table) {
            $table->id();
            $table->string('product_ct_id');
            $table->string('description');
            $table->decimal('d_kawat', 8, 2)->nullable();
            $table->decimal('tol_d', 8, 2)->nullable();
            $table->decimal('p_product', 8, 2)->nullable();
            $table->decimal('l_product', 8, 2)->nullable();
            $table->decimal('l_mesh', 8, 2)->nullable();
            $table->decimal('l2_mesh', 8, 2)->nullable();
            $table->decimal('p_mesh', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_cts');
    }
};
