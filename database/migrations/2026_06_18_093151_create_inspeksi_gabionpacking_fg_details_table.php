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
        Schema::create('inspeksi_gabionpacking_fg_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inspeksi_gabionpacking_fg_id');
            $table->foreign('inspeksi_gabionpacking_fg_id', 'fg_detail_fk')
                ->references('id')
                ->on('inspeksi_gabionpacking_fgs')
                ->onDelete('cascade');

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
        Schema::dropIfExists('inspeksi_gabionpacking_fg_details');
    }
};
