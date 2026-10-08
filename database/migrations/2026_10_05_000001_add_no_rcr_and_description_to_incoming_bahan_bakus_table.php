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
        Schema::table('incoming_bahan_bakus', function (Blueprint $table) {
            $table->string('no_rcr')->nullable()->after('supplier_id');
            $table->text('description')->nullable()->after('no_rcr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_bahan_bakus', function (Blueprint $table) {
            $table->dropColumn(['no_rcr', 'description']);
        });
    }
};
