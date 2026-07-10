<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspeksi_wm_fgs', function (Blueprint $table) {
            $table->string('lot_number', 50)->nullable()->after('label');
        });
    }

    public function down(): void
    {
        Schema::table('inspeksi_wm_fgs', function (Blueprint $table) {
            $table->dropColumn('lot_number');
        });
    }
};
