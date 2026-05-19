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
        Schema::create('inspeksi_razorpackings', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inspeksi');
            $table->date('tanggal');
            $table->foreignId('pro_id')->constrained('pros')->onDelete('cascade');
            $table->foreignId('product_razor_ref_id')->nullable()->constrained('product_razors')->onDelete('cascade');
            $table->integer('shift');
            $table->decimal('total_prod', 8, 2)->nullable();
            $table->foreignId('mesin_id')->nullable()->constrained('mesins');
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
        Schema::dropIfExists('inspeksi_razorpackings');
    }
};
