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
        Schema::table('claims', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->change();
            $table->string('full_name')->nullable()->after('tool_id');
            $table->string('work_email')->nullable()->after('full_name');
            $table->string('company_name')->nullable()->after('work_email');
            $table->string('company_website')->nullable()->after('company_name');
            $table->text('verification_info')->nullable()->after('company_website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'work_email',
                'company_name',
                'company_website',
                'verification_info',
            ]);
        });
    }
};
