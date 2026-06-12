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
        Schema::create('inspeksi_gabionrakit_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_gabionrakit_id')->constrained('inspeksi_gabionrakits')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator');
            $table->decimal('p_act', 8, 2)->nullable();
            $table->decimal('l_act', 8, 2)->nullable();
            $table->decimal('t_act', 8, 2)->nullable();
            $table->string('type');
            $table->decimal('jml_sekat', 8, 2)->nullable();
            $table->decimal('mesh1', 8, 2)->nullable();
            $table->decimal('mesh2', 8, 2)->nullable();
            $table->string('visual')->nullable();
            $table->string('status')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_gabionrakit_wips');
    }
};
