<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| Tutor & Allied AI Academy - Inbound Webhooks
|
| These endpoints receive data from external services.
| All routes use 'webhook.signature' middleware for verification.
|
| Registered webhook URLs:
| - GitHub App: https://Tutor-Allied.dev/webhooks/github
| - SendGrid:   https://Tutor-Allied.dev/webhooks/sendgrid (future)
| - Mailgun:    https://Tutor-Allied.dev/webhooks/mailgun (future)
| - Pusher:     https://Tutor-Allied.dev/webhooks/pusher (future)
|
*/

// Central webhook router
Route::post('/webhooks/{provider}', [App\Http\Controllers\Integrations\Webhooks\WebhookRouterController::class, 'handle'])
    ->name('webhooks.handle')
    ->middleware('webhook.signature');

// GitHub App webhook
Route::post('/webhooks/github', [App\Http\Controllers\Integrations\Webhooks\GitHubWebhookController::class, 'handle'])
    ->name('webhooks.github')
    ->middleware('webhook.signature');

// ============================================================================
// Provider-specific webhook examples (for future expansion)
// ============================================================================

// Email delivery webhooks (SendGrid/Mailgun)
Route::post('/webhooks/sendgrid', [App\Http\Controllers\Integrations\Webhooks\SendGridWebhookController::class, 'handle'])
    ->name('webhooks.sendgrid')
    ->middleware('webhook.signature');

Route::post('/webhooks/mailgun', [App\Http\Controllers\Integrations\Webhooks\MailgunWebhookController::class, 'handle'])
    ->name('webhooks.mailgun')
    ->middleware('webhook.signature');

// Real-time events (Pusher)
Route::post('/webhooks/pusher', [App\Http\Controllers\Integrations\Webhooks\PusherWebhookController::class, 'handle'])
    ->name('webhooks.pusher')
    ->middleware('webhook.signature');

// Stripe webhooks (NOT USED - no payments enabled)
// Route::post('/webhooks/stripe', ...)->name('webhooks.stripe');

// Custom webhook endpoint for generic integrations
Route::post('/webhooks/custom/{key}', [App\Http\Controllers\Integrations\Webhooks\CustomWebhookController::class, 'handle'])
    ->name('webhooks.custom')
    ->middleware('webhook.signature');
