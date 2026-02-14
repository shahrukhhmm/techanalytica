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
    Schema::create('industries', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('name');
      $table->string('slug')->unique();
      $table->text('description')->nullable();
      $table->uuid('suggested_by_vendor_id')->nullable();
      $table->boolean('approved')->default(true);
      $table->timestamps();

      $table->foreign('suggested_by_vendor_id')
        ->references('id')->on('vendors')
        ->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('industries');
  }
};
