<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('track_day_completions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('enrollment_id')->constrained('track_enrollments')->cascadeOnDelete();
      $table->unsignedTinyInteger('day_number'); // 1..14

      // tasks JSON mirrors TrackSeeder tasks, but stores user completion state
      // Example: [{"text":"Install tools","done":true},{"text":"Join community","done":false}]
      $table->json('tasks_state')->nullable();

      $table->boolean('is_completed')->default(false)->index();
      $table->timestamp('completed_at')->nullable();
      $table->timestamps();

      $table->unique(['enrollment_id','day_number']);
      $table->index(['enrollment_id','is_completed']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('track_day_completions');
  }
};
