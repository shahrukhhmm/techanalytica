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
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('rating');
            $table->string('verification_type')->nullable()->after('is_verified');
            $table->text('vendor_reply')->nullable()->after('comment');
            $table->timestamp('vendor_replied_at')->nullable()->after('vendor_reply');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'is_verified',
                'verification_type',
                'vendor_reply',
                'vendor_replied_at',
            ]);
        });
    }
};
