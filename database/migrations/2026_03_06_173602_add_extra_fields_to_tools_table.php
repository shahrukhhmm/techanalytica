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
        Schema::table('tools', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->integer('rank')->default(0)->after('is_featured');
            $table->boolean('is_verified')->default(false)->after('rank');
            $table->boolean('is_locked')->default(false)->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'rank', 'is_verified', 'is_locked']);
        });
    }
};
