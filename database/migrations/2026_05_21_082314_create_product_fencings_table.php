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
        Schema::create('product_fencings', function (Blueprint $table) {
            $table->id();
            $table->string('product_fencing_id');
            $table->string('description');
            $table->decimal('d1', 8, 2)->nullable();
            $table->decimal('d2', 8, 2)->nullable();
            $table->decimal('tol_d1', 8, 2)->nullable();
            $table->decimal('tol_d2', 8, 2)->nullable();
            $table->decimal('p_before', 8, 2)->nullable();
            $table->decimal('p_after', 8, 2)->nullable();
            $table->decimal('l_before', 8, 2)->nullable();
            $table->decimal('l_after', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_fencings');
    }
};
