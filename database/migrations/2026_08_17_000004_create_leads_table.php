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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('company_name')->nullable();
            $table->string('company_size')->nullable();
            $table->string('phone')->nullable();
            $table->enum('intent_type', ['demo', 'pricing', 'contact', 'custom_quote'])->default('demo');
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'qualified', 'closed'])->default('new');
            $table->timestamps();

            $table->index(['tool_id', 'status']);
            $table->index(['vendor_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
