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
        Schema::create('lks_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lks_id')->constrained()->cascadeOnDelete();
            $table->string('lot_number', 50);
            $table->string('sumber', 20); // 'inspeksi' atau 'mechanical'
            $table->unsignedBigInteger('sumber_id');
            $table->string('no_koil')->nullable();
            $table->string('status', 20); // NG atau REJECT
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->date('tanggal_inspeksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lks_details');
    }
};
