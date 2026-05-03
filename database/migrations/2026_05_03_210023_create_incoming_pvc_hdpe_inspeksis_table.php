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
        Schema::create('incoming_pvc_hdpe_inspeksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_pvc_hdpe_id')->constrained('incoming_pvc_hdpes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('visual');
            $table->string('certificate')->nullable();
            $table->json('files')->nullable(); // simpan array path file upload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_pvc_hdpe_inspeksis');
    }
};
