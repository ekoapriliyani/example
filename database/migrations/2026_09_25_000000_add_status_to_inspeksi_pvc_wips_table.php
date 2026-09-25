<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspeksi_pvc_wips', function (Blueprint $table) {
            $table->string('status')->nullable()->after('visual');
        });
    }

    public function down(): void
    {
        Schema::table('inspeksi_pvc_wips', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
