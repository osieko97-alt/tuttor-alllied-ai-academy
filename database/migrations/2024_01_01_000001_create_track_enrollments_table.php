<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('track_enrollments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('track_id')->constrained('tracks')->cascadeOnDelete();

      // Sprint timeline
      $table->date('start_date')->nullable();
      $table->date('target_end_date')->nullable(); // start + 14 days
      $table->unsignedTinyInteger('current_day')->default(1); // 1..14

      // Status
      $table->enum('status', ['active','paused','completed','dropped'])->default('active')->index();

      // Link to incubation project they are building (nullable until they choose)
      $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();

      $table->timestamps();

      $table->unique(['user_id','track_id']); // one active enrollment per track
      $table->index(['user_id','status']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('track_enrollments');
  }
};
