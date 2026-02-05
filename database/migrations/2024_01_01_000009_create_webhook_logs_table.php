<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // github, sendgrid, mailgun, pusher
            $table->string('event_type')->nullable();
            $table->json('headers')->nullable();
            $table->json('payload');
            $table->enum('status', ['received', 'processed', 'failed', ' replayed'])->default('received');
            $table->text('error_message')->nullable();
            $table->unsignedBigInteger('processed_by_user_id')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['provider', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
