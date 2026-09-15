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
        Schema::table('mechanical_tests', function (Blueprint $table) {
            $table->string('lot_number', 50)->nullable()->unique()->after('description2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mechanical_tests', function (Blueprint $table) {
            $table->dropColumn('lot_number');
        });
    }
};
