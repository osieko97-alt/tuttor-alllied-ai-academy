<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_type'); // forum_post, forum_thread, chat_message, project, review
            $table->unsignedBigInteger('reportable_id');
            $table->string('reportable_type');
            $table->unsignedBigInteger('reporter_id');
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('moderator_id')->nullable();
            $table->text('moderator_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['report_type', 'status']);
            $table->index(['reportable_type', 'reportable_id']);
            $table->index('reporter_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
