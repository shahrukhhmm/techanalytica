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
    Schema::create('claims', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('tool_id');
      $table->uuid('vendor_id');
      $table->enum('status', ['pending', 'approved', 'rejected']);
      $table->text('reason')->nullable();
      $table->timestamps();

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
      $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('claims');
  }
};
