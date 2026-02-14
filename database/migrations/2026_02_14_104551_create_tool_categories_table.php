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
    Schema::create('tool_category', function (Blueprint $table) {
      $table->uuid('tool_id');
      $table->uuid('category_id');

      $table->primary(['tool_id', 'category_id']);

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tool_categories');
  }
};
