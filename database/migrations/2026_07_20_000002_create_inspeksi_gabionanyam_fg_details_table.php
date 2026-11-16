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
        Schema::create('inspeksi_gabionanyam_fg_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_gabionanyam_fg_id')
                ->constrained('inspeksi_gabionanyam_fgs')
                ->onDelete('cascade')
                ->name('fk_gabionanyam_fg_details');
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
        Schema::dropIfExists('inspeksi_gabionanyam_fg_details');
    }
};
