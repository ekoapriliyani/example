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
        Schema::create('inspeksi_chainlink_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_chainlink_id')->constrained('inspeksi_chainlinks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator')->nullable();
            $table->decimal('lebar', 8, 2)->nullable();
            $table->decimal('panjang', 8, 2)->nullable();
            $table->decimal('mesh', 8, 2)->nullable();
            $table->decimal('diameter', 8, 2)->nullable();
            $table->string('type');
            $table->string('model');
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
        Schema::dropIfExists('inspeksi_chainlink_wips');
    }
};
