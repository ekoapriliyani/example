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
        Schema::create('inspeksi_gabionframe_fg_handling_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handling_id')
                ->constrained('inspeksi_gabionframe_fg_handlings')
                ->cascadeOnDelete()
                ->name('fk_gabionframe_fg_handling_details');
            $table->string('status');
            $table->integer('qty');
            $table->decimal('weight', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_gabionframe_fg_handling_details');
    }
};
