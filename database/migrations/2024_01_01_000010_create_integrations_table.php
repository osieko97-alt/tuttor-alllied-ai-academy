<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // github, google, sendgrid, mailgun, pusher, aws
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->text('settings')->nullable(); // JSON config (non-sensitive)
            $table->text('secret_encrypted')->nullable(); // Encrypted API keys/tokens
            $table->timestamp('last_tested_at')->nullable();
            $table->string('last_test_status')->nullable(); // success, failed
            $table->text('last_test_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
