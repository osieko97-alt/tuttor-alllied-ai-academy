<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('deploy_checklist_templates', function (Blueprint $table) {
      $table->id();
      $table->string('name'); // e.g. "Web App MVP", "Chatbot MVP"
      $table->string('slug')->unique();
      $table->string('audience')->nullable(); // developers/creators/ai-real-world etc
      $table->text('description')->nullable();
      $table->boolean('is_active')->default(true)->index();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('deploy_checklist_templates');
  }
};
