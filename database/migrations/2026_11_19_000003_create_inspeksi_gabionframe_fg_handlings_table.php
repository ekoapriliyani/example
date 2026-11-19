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
        Schema::create('inspeksi_gabionframe_fg_handlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_gabionframe_fg_id')
                ->constrained('inspeksi_gabionframe_fgs')
                ->cascadeOnDelete()
                ->name('fk_gabionframe_fg_handlings');
            $table->date('tanggal');
            $table->foreignId('user_id')->constrained();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_gabionframe_fg_handlings');
    }
};
