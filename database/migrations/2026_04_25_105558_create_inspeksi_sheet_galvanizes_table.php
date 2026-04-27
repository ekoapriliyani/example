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
        Schema::create('inspeksi_sheet_galvanizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_sheet_galvanize_id')->constrained('sheet_galvanizes')->onDelete('cascade');
            $table->string('tebal');
            $table->string('coating');
            $table->string('visual');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_sheet_galvanizes');
    }
};
