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
        Schema::create('outgoing_inspeksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_id')->constrained('outgoings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Perbaikan: Tambahkan opsi '-' ke dalam enum dan berikan default('-')
            $table->enum('label', ['OK', 'NG', '-'])->default('-');
            $table->enum('karat', ['OK', 'NG', '-'])->default('-');
            $table->enum('penyok', ['OK', 'NG', '-'])->default('-');
            $table->enum('kotor', ['OK', 'NG', '-'])->default('-');
            $table->enum('galvanized', ['OK', 'NG', '-'])->default('-');
            $table->enum('lasan', ['OK', 'NG', '-'])->default('-');
            $table->enum('mesh', ['OK', 'NG', '-'])->default('-');
            $table->enum('pvc', ['OK', 'NG', '-'])->default('-');
            $table->enum('packing', ['OK', 'NG', '-'])->default('-');
            $table->enum('qty', ['OK', 'NG', '-'])->default('-');

            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_inspeksis');
    }
};
