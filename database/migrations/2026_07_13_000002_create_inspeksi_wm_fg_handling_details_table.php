<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspeksi_wm_fg_handling_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handling_id')->constrained('inspeksi_wm_fg_handlings')->cascadeOnDelete();
            $table->string('status');
            $table->integer('qty');
            $table->decimal('weight', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_wm_fg_handling_details');
    }
};
