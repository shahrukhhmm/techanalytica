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
    Schema::create('tool_industry', function (Blueprint $table) {
      $table->uuid('tool_id');
      $table->uuid('industry_id');

      $table->primary(['tool_id', 'industry_id']);

      $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
      $table->foreign('industry_id')->references('id')->on('industries')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tool_industries');
  }
};
