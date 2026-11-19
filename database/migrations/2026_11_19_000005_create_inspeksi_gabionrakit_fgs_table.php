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
        Schema::create('inspeksi_gabionrakit_fgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_gabionrakit_id')->constrained('inspeksi_gabionrakits')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status');
            $table->integer('qty');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('packing');
            $table->string('label');
            $table->string('lot_number', 50)->nullable()->unique();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_gabionrakit_fgs');
    }
};
