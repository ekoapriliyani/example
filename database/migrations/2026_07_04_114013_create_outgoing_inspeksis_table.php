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

            // Optimasi: Gunakan enum untuk memastikan input hanya berisi 'OK' atau 'NG'
            $table->enum('label', ['OK', 'NG']);
            $table->enum('karat', ['OK', 'NG']);
            $table->enum('penyok', ['OK', 'NG']);
            $table->enum('kotor', ['OK', 'NG']);
            $table->enum('galvanized', ['OK', 'NG']);
            $table->enum('lasan', ['OK', 'NG']);
            $table->enum('mesh', ['OK', 'NG']);
            $table->enum('pvc', ['OK', 'NG']);
            $table->enum('packing', ['OK', 'NG']);
            $table->enum('qty', ['OK', 'NG']);
            $table->json('files')->nullable(); // simpan array path file upload
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
