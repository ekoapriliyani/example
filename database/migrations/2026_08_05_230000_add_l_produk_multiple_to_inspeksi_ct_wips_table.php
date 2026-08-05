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
        Schema::table('inspeksi_ct_wips', function (Blueprint $table) {
            $table->renameColumn('l_produk', 'l_produk_1');
            $table->decimal('l_produk_2', 8, 2)->nullable();
            $table->decimal('l_produk_3', 8, 2)->nullable();
            $table->decimal('l_produk_4', 8, 2)->nullable();
            $table->decimal('l_produk_5', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspeksi_ct_wips', function (Blueprint $table) {
            $table->dropColumn(['l_produk_2', 'l_produk_3', 'l_produk_4', 'l_produk_5']);
            $table->renameColumn('l_produk_1', 'l_produk');
        });
    }
};