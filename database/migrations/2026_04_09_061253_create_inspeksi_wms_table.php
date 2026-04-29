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
            Schema::create('inspeksi_wms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inspeksi');
            $table->foreignId('pro_id')->constrained('pros');
            $table->foreignId('product_wm_ref_id')->nullable()->constrained('product_wms');
            $table->string('shift');
            $table->string('grade');
            $table->string('type_coating');
            $table->foreignId('mesin_id')->nullable()->constrained('mesins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wms');
    }
};
