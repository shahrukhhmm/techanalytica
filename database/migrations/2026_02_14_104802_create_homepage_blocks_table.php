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
    Schema::create('homepage_blocks', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->enum('block_type', [
        'hero',
        'featured_tools',
        'categories',
        'blog_highlight'
      ]);
      $table->json('content')->nullable();
      $table->integer('sort_order')->default(0);
      $table->timestamp('updated_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('homepage_blocks');
  }
};
