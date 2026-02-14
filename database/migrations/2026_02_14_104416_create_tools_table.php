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
    Schema::create('tools', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('vendor_id')->nullable();
      $table->uuid('tier_id')->nullable();

      $table->string('name');
      $table->string('slug')->unique();
      $table->string('logo_url')->nullable();

      $table->text('short_description')->nullable();
      $table->text('long_description')->nullable();

      $table->string('website_url')->nullable();

      $table->json('pricing_structured')->nullable();
      $table->text('pricing_text')->nullable();

      $table->enum('cta_type', [
        'website',
        'signup',
        'demo',
        'free_trial',
        'contact_sales'
      ])->nullable();

      $table->string('cta_url')->nullable();

      $table->enum('status', ['draft', 'pending', 'published', 'archived']);
      $table->boolean('is_claimed')->default(false);

      $table->timestamp('published_at')->nullable();
      $table->timestamp('last_edited_at')->nullable();

      $table->timestamps();

      $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();
      $table->foreign('tier_id')->references('id')->on('pricing_tiers')->nullOnDelete();

      $table->index(['status', 'published_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tools');
  }
};
