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
      $table->uuid('id')->primary();
      $table->uuid('vendor_id');
      $table->uuid('tool_id')->nullable();

      $table->decimal('amount', 10, 2);
      $table->string('currency', 10);

      $table->enum('type', ['upgrade', 'sponsorship', 'analytics']);
      $table->enum('status', ['pending', 'paid', 'failed', 'refunded']);

      $table->string('external_tx_id')->nullable();

      $table->timestamps();

      $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
      $table->foreign('tool_id')->references('id')->on('tools')->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('billing_reansactions');
  }
};
