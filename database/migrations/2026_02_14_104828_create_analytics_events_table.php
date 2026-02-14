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
    Schema::create('analytics_events', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('tool_id');
      $table->uuid('vendor_id')->nullable();
      $table->enum('event_type', ['view', 'cta_click']);
      $table->timestamp('timestamp');
      $table->string('referrer')->nullable();
      $table->string('session_id')->nullable();
      $table->string('device')->nullable();

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
      $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();

      $table->index(['tool_id', 'event_type']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('analytics_events');
  }
};
