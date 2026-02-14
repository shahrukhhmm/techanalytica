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
    Schema::create('submissions', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('vendor_id');
      $table->string('tool_name');
      $table->json('fields');
      $table->enum('status', ['draft', 'pending', 'approved', 'rejected']);
      $table->timestamps();

      $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('submissions');
  }
};
