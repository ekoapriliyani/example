<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pro_references', function (Blueprint $table) {
            $table->id();
            $table->string('trno', 50);
            $table->text('description');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
            $table->unique(['trno', 'description']);
            $table->index('trno');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pro_references');
    }
};