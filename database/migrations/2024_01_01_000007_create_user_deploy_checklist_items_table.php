<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('user_deploy_checklist_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_checklist_id')->constrained('user_deploy_checklists')->cascadeOnDelete();
      $table->foreignId('item_id')->constrained('deploy_checklist_items')->cascadeOnDelete();

      $table->boolean('is_done')->default(false)->index();
      $table->timestamp('done_at')->nullable();

      // evidence (optional)
      $table->string('repo_url')->nullable();
      $table->string('demo_url')->nullable();
      $table->text('notes')->nullable();

      $table->timestamps();

      $table->unique(['user_checklist_id','item_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('user_deploy_checklist_items');
  }
};
