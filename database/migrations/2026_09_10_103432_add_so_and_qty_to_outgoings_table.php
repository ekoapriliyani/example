<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outgoings', function (Blueprint $table) {
            $table->string('so')->nullable()->after('shipment_id');
            $table->decimal('qty', 12, 2)->nullable()->after('produk');
        });
    }

    public function down(): void
    {
        Schema::table('outgoings', function (Blueprint $table) {
            $table->dropColumn(['so', 'qty']);
        });
    }
};
