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
      $table->id();
      $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
      $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
      $table->enum('placement_type', ['category', 'homepage', 'newsletter']);
      $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
      $table->date('start_date');
      $table->date('end_date');
      $table->enum('status', ['inactive', 'active', 'expired']);
      $table->timestamps();

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
