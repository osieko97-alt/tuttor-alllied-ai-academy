<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('deploy_checklist_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('template_id')->constrained('deploy_checklist_templates')->cascadeOnDelete();

      $table->string('group')->default('General'); // e.g. "Code", "Docs", "Deploy"
      $table->string('title'); // "README with setup steps"
      $table->text('help_text')->nullable(); // guidance
      $table->unsignedSmallInteger('sort_order')->default(0);

      // Evidence requirement flags
      $table->boolean('requires_repo')->default(false);
      $table->boolean('requires_demo')->default(false);

      $table->boolean('is_required')->default(true);
      $table->timestamps();

      $table->index(['template_id','group']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('deploy_checklist_items');
  }
};
