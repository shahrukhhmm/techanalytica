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
    Schema::create('billing_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
      $table->foreignId('tool_id')->nullable()->constrained()->nullOnDelete();

      $table->decimal('amount', 10, 2);
      $table->string('currency', 10);

      $table->enum('type', ['upgrade', 'sponsorship', 'analytics']);
      $table->enum('status', ['pending', 'paid', 'failed', 'refunded']);

      $table->string('external_tx_id')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('billing_transactions');
  }
};
