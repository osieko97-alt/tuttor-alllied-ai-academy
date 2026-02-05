<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('track_day_submissions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('enrollment_id')->constrained('track_enrollments')->cascadeOnDelete();
      $table->unsignedTinyInteger('day_number'); // 1..14
      $table->text('notes')->nullable();

      // Evidence fields
      $table->string('repo_url')->nullable();
      $table->string('demo_url')->nullable();
      $table->string('pr_url')->nullable();
      $table->string('commit_hash')->nullable();

      $table->timestamps();

      $table->index(['enrollment_id','day_number']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('track_day_submissions');
  }
};
