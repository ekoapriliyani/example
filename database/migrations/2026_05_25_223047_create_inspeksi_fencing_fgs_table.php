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
        Schema::create('inspeksi_fencing_fgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeksi_fencing_id')->constrained('inspeksi_fencings')->onDelete('cascade'); // relasi ke header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->decimal('coating_thickness', 8, 2)->nullable();
            $table->string('daya_rekat');
            $table->string('visual');
            $table->string('packing');
            $table->string('label');
            $table->string('status');
            $table->integer('qty');
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('files')->nullable(); // simpan array path file upload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_fencing_fgs');
    }
};
