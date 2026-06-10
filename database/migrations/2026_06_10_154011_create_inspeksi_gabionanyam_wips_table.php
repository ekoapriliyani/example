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
        Schema::create('inspeksi_gabionanyam_wips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_gabionanyam_id')->constrained('inspeksi_gabionanyams')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_material')->nullable();
            $table->string('nama_operator');
            $table->decimal('l1_act', 8, 2)->nullable();
            $table->decimal('l2_act', 8, 2)->nullable();
            $table->decimal('d_anyam', 8, 2)->nullable();
            $table->decimal('d_frame', 8, 2)->nullable();
            $table->decimal('d_anyam_pvc', 8, 2)->nullable();
            $table->decimal('d_frame_pvc', 8, 2)->nullable();

            $table->decimal('mesh1', 8, 2)->nullable();
            $table->decimal('mesh2', 8, 2)->nullable();
            $table->decimal('p_lilitan', 8, 2)->nullable();
            $table->decimal('jml_lilitan', 8, 2)->nullable();
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
        Schema::dropIfExists('inspeksi_gabionanyam_wips');
    }
};
