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
        Schema::create('inspeksi_razorpacking_fg_details', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel utama
            $table->unsignedBigInteger('inspeksi_razorpacking_fg_id');
            $table->foreign(
                'inspeksi_razorpacking_fg_id',
                'irfg_detail_fg_id_fk'
            )->references('id')
                ->on('inspeksi_razorpacking_fgs')
                ->onDelete('cascade');

            // field detail
            $table->string('description')->nullable();
            $table->string('description2')->nullable();
            $table->integer('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_razorpacking_fg_details');
    }
};
