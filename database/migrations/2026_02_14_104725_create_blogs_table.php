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
    Schema::create('blogs', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('title');
      $table->string('slug')->unique();
      $table->longText('body');
      $table->uuid('author_id');

      $table->enum('status', ['draft', 'published']);
      $table->timestamp('published_at')->nullable();

      $table->string('meta_title')->nullable();
      $table->text('meta_description')->nullable();
      $table->string('og_image')->nullable();

      $table->timestamps();

      $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blogs');
  }
};
