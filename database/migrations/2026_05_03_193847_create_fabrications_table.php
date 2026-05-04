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
        Schema::create('fabrications', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('subkon_id')->constrained('subkons')->onDelete('cascade');
            $table->string('report_no');
            $table->string('drawing_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabrications');
    }
};
