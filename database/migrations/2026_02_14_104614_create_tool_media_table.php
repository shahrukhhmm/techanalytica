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
    Schema::create('tool_media', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('tool_id');
      $table->enum('type', ['screenshot', 'video']);
      $table->string('url');
      $table->integer('sort_order')->default(0);
      $table->timestamps();

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tool_media');
  }
};
