<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspeksi_shearing_fgs', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
            $table->string('daya_rekat')->nullable()->change();
            $table->string('visual')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('inspeksi_shearing_fgs', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
            $table->string('daya_rekat')->nullable(false)->change();
            $table->string('visual')->nullable(false)->change();
        });
    }
};
