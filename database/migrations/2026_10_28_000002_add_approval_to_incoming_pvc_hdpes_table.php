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
        Schema::table('incoming_pvc_hdpes', function (Blueprint $table) {
            $table->string('approval_status')->nullable()->after('certificate');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_pvc_hdpes', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'approved_by', 'approved_at']);
        });
    }
};
