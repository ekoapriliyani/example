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
        Schema::create('lks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_lks', 50)->unique();
            $table->foreignId('supplier_id')->constrained();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->string('status', 20)->default('DRAFT'); // DRAFT, APPROVED, CLOSED
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lks');
    }
};
