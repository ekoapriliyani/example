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
        Schema::table('outgoing_defects', function (Blueprint $table) {
            $table->renameColumn('jml_ng', 'qty');
        });

        Schema::table('outgoing_defects', function (Blueprint $table) {
            $table->enum('status', ['NG', 'REJECT'])->default('NG')->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_defects', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('outgoing_defects', function (Blueprint $table) {
            $table->renameColumn('qty', 'jml_ng');
        });
    }
};
