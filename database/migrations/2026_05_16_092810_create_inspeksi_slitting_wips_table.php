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
        Schema::create('inspeksi_slitting_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_slitting_id')->constrained('inspeksi_slittings')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator')->nullable();
            $table->decimal('l_sheetgalvanized', 8, 2)->nullable();
            $table->decimal('tebal_sheetgalvanized', 8, 2)->nullable();
            $table->string('visual')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('status');
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_slitting_wips');
    }
};
