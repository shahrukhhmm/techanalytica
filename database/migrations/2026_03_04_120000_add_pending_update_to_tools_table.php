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
        Schema::table('tools', function (Blueprint $create) {
            $create->json('pending_data')->nullable()->after('status');
            $create->boolean('has_pending_update')->default(false)->after('pending_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $create) {
            $create->dropColumn(['pending_data', 'has_pending_update']);
        });
    }
};
