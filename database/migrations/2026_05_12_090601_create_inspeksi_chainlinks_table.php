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
        Schema::create('inspeksi_chainlinks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inspeksi');
            $table->date('tanggal');
            $table->foreignId('pro_id')->constrained('pros')->onDelete('cascade');
            $table->integer('shift');
            $table->foreignId('mesin_id')->nullable()->constrained('mesins');
            $table->decimal('jml_lubang_p', 8, 2)->nullable();
            $table->decimal('jml_counter', 8, 2)->nullable();
            $table->decimal('jml_lubang_l', 8, 2)->nullable();
            $table->decimal('total_prod', 8, 2)->nullable();
            // Approval
            $table->string('approval_status')->default('PENDING');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_chainlinks');
    }
};
