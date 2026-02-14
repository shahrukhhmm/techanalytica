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
    Schema::create('sponsorships', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('tool_id');
      $table->uuid('vendor_id');
      $table->enum('placement_type', ['category', 'homepage', 'newsletter']);
      $table->uuid('category_id')->nullable();
      $table->date('start_date');
      $table->date('end_date');
      $table->enum('status', ['inactive', 'active', 'expired']);
      $table->timestamps();

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
      $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
      $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();

      $table->index(['status', 'end_date']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sponsorships');
  }
};
