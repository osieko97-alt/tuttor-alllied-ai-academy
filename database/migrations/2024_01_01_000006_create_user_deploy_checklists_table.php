<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('user_deploy_checklists', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('enrollment_id')->constrained('track_enrollments')->cascadeOnDelete();

      $table->foreignId('template_id')->constrained('deploy_checklist_templates')->cascadeOnDelete();

      // Overall state
      $table->enum('status', ['in_progress','deploy_ready','completed'])->default('in_progress')->index();
      $table->timestamp('deploy_ready_at')->nullable();
      $table->timestamp('completed_at')->nullable();

      $table->timestamps();

      $table->unique(['user_id','enrollment_id']); // one checklist per sprint
      $table->index(['user_id','status']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('user_deploy_checklists');
  }
};
