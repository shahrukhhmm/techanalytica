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
    Schema::create('vendors', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('user_id')->unique();
    $table->string('company_name')->nullable();
    $table->string('company_website')->nullable();
    $table->string('company_size')->nullable();
    $table->string('designation')->nullable();
    $table->string('department')->nullable();
    $table->string('phone')->nullable();
    $table->string('billing_email')->nullable();
    $table->text('billing_address')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vendors');
  }
};
