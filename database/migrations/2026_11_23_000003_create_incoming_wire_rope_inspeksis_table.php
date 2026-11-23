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
        Schema::create('incoming_wire_rope_inspeksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_wire_rope_id')->constrained('incoming_wire_ropes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_koil')->nullable();

            // Inspeksi Wire Rope
            $table->decimal('d1_wire_rope', 8, 2)->nullable();
            $table->decimal('d2_wire_rope', 8, 2)->nullable();
            $table->decimal('d3_wire_rope', 8, 2)->nullable();
            $table->decimal('d1_kawat_inti', 8, 2)->nullable();
            $table->decimal('d2_kawat_inti', 8, 2)->nullable();
            $table->decimal('d3_kawat_inti', 8, 2)->nullable();
            $table->unsignedInteger('jml_kawat_inti')->nullable();
            $table->string('dimensi')->nullable();
            $table->string('visual')->nullable();
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->string('lot_number')->nullable();
            $table->json('files')->nullable();

            // Mechanical Test
            $table->foreignId('mechanical_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('mechanical_status')->nullable();
            $table->decimal('tensile_strength_kawat_inti', 10, 2)->nullable();
            $table->string('mechanical_lot_number')->nullable();
            $table->json('mechanical_files')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_wire_rope_inspeksis');
    }
};
