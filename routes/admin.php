<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Tutor & Allied AI Academy - Admin Panel
| All routes require 'auth' and 'ensureAdmin' middleware
|
| Prefix: /admin
|
*/

Route::prefix('admin')
    ->middleware(['auth', 'ensureAdmin'])
    ->group(function () {

        // -------------------------------------------------------------------------
        // Admin Home
        // -------------------------------------------------------------------------
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.home');

        // -------------------------------------------------------------------------
        // Users Management
        // -------------------------------------------------------------------------
        Route::get('/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{userId}', [App\Http\Controllers\Admin\UsersController::class, 'show'])->name('admin.users.show');
        Route::post('/users/{userId}/action', [App\Http\Controllers\Admin\UsersController::class, 'action'])->name('admin.users.action');

        // -------------------------------------------------------------------------
        // Academy Admin
        // -------------------------------------------------------------------------
        Route::get('/tracks', [App\Http\Controllers\Admin\TracksAdminController::class, 'index'])->name('admin.tracks.index');
        Route::get('/tracks/{trackId}/edit', [App\Http\Controllers\Admin\TracksAdminController::class, 'edit'])->name('admin.tracks.edit');
        Route::post('/tracks/{trackId}', [App\Http\Controllers\Admin\TracksAdminController::class, 'update'])->name('admin.tracks.update');
        Route::get('/deploy-templates', [App\Http\Controllers\Admin\TracksAdminController::class, 'deployTemplates'])->name('admin.deploy-templates');
        Route::post('/deploy-templates/{templateId}', [App\Http\Controllers\Admin\TracksAdminController::class, 'updateDeployTemplate'])->name('admin.deploy-templates.update');

        // -------------------------------------------------------------------------
        // Courses Admin
        // -------------------------------------------------------------------------
        Route::get('/courses', [App\Http\Controllers\Admin\CoursesAdminController::class, 'index'])->name('admin.courses.index');
        Route::post('/courses', [App\Http\Controllers\Admin\CoursesAdminController::class, 'store'])->name('admin.courses.store');
        Route::post('/courses/{courseId}', [App\Http\Controllers\Admin\CoursesAdminController::class, 'update'])->name('admin.courses.update');

        // -------------------------------------------------------------------------
        // Incubation Admin
        // -------------------------------------------------------------------------
        Route::get('/projects', [App\Http\Controllers\Admin\ProjectsAdminController::class, 'index'])->name('admin.projects.index');
        Route::post('/projects/{projectId}/feature', [App\Http\Controllers\Admin\ProjectsAdminController::class, 'featureToggle'])->name('admin.projects.feature');
        Route::get('/projects/reports', [App\Http\Controllers\Admin\ProjectsAdminController::class, 'reports'])->name('admin.projects.reports');

        // -------------------------------------------------------------------------
        // Forum Admin
        // -------------------------------------------------------------------------
        Route::get('/forum', [App\Http\Controllers\Admin\ForumAdminController::class, 'index'])->name('admin.forum.index');
        Route::post('/forum/threads/{threadId}/lock', [App\Http\Controllers\Admin\ForumAdminController::class, 'lock'])->name('admin.forum.lock');
        Route::post('/forum/threads/{threadId}/pin', [App\Http\Controllers\Admin\ForumAdminController::class, 'pin'])->name('admin.forum.pin');

        // -------------------------------------------------------------------------
        // Chat Admin
        // -------------------------------------------------------------------------
        Route::get('/chat', [App\Http\Controllers\Admin\ChatAdminController::class, 'index'])->name('admin.chat.index');
        Route::post('/admin/chat/channels/{channelId}/lock', [App\Http\Controllers\Admin\ChatAdminController::class, 'lock'])->name('admin.chat.lock');

        // -------------------------------------------------------------------------
        // Partners Admin
        // -------------------------------------------------------------------------
        Route::get('/partners', [App\Http\Controllers\Admin\PartnersAdminController::class, 'index'])->name('admin.partners.index');
        Route::get('/partners/verification', [App\Http\Controllers\Admin\PartnersAdminController::class, 'verificationQueue'])->name('admin.partners.verification');
        Route::post('/partners/verification/{requestId}/approve', [App\Http\Controllers\Admin\PartnersAdminController::class, 'approveVerification'])->name('admin.partners.verification.approve');
        Route::post('/partners/verification/{requestId}/reject', [App\Http\Controllers\Admin\PartnersAdminController::class, 'rejectVerification'])->name('admin.partners.verification.reject');

        // -------------------------------------------------------------------------
        // Moderation Center
        // -------------------------------------------------------------------------
        Route::get('/moderation', [App\Http\Controllers\Admin\ModerationController::class, 'index'])->name('admin.moderation.index');
        Route::post('/moderation/action', [App\Http\Controllers\Admin\ModerationController::class, 'act'])->name('admin.moderation.act');

        // -------------------------------------------------------------------------
        // Admin Integrations Manager
        // -------------------------------------------------------------------------
        Route::get('/integrations', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'index'])->name('admin.integrations.index');
        Route::get('/integrations/{key}/edit', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'edit'])->name('admin.integrations.edit');
        Route::post('/integrations/{key}', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'update'])->name('admin.integrations.update');
        Route::post('/integrations/{key}/enable', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'enable'])->name('admin.integrations.enable');
        Route::post('/integrations/{key}/disable', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'disable'])->name('admin.integrations.disable');
        Route::post('/integrations/{key}/rotate', [App\Http\Controllers\Admin\Integrations\IntegrationsController::class, 'rotateSecrets'])->name('admin.integrations.rotate');

        // Integration testing
        Route::get('/integrations/{key}/test', [App\Http\Controllers\Admin\Integrations\TestsController::class, 'show'])->name('admin.integrations.test');
        Route::post('/integrations/{key}/test/run', [App\Http\Controllers\Admin\Integrations\TestsController::class, 'run'])->name('admin.integrations.test.run');

        // Webhooks management
        Route::get('/integrations/{key}/webhooks', [App\Http\Controllers\Admin\Integrations\WebhooksController::class, 'index'])->name('admin.integrations.webhooks');
        Route::post('/integrations/{key}/webhooks/secret', [App\Http\Controllers\Admin\Integrations\WebhooksController::class, 'rotateSecret'])->name('admin.integrations.webhooks.secret');
        Route::post('/integrations/{key}/webhooks/replay/{eventLogId}', [App\Http\Controllers\Admin\Integrations\WebhooksController::class, 'replay'])->name('admin.integrations.webhooks.replay');

        // Integration logs
        Route::get('/integrations/{key}/logs', [App\Http\Controllers\Admin\Integrations\LogsController::class, 'index'])->name('admin.integrations.logs');

        // -------------------------------------------------------------------------
        // System Ops Routes (health, jobs, scheduler, backups)
        // -------------------------------------------------------------------------
        Route::get('/system/health', [App\Http\Controllers\Admin\System\HealthController::class, 'index'])->name('admin.system.health');
        Route::post('/system/health/run', [App\Http\Controllers\Admin\System\HealthController::class, 'run'])->name('admin.system.health.run');

        Route::get('/system/jobs', [App\Http\Controllers\Admin\System\JobsController::class, 'index'])->name('admin.system.jobs');
        Route::post('/system/jobs/retry/{jobId}', [App\Http\Controllers\Admin\System\JobsController::class, 'retry'])->name('admin.system.jobs.retry');

        Route::get('/system/scheduler', [App\Http\Controllers\Admin\System\SchedulerController::class, 'index'])->name('admin.system.scheduler');
        Route::post('/system/scheduler/run', [App\Http\Controllers\Admin\System\SchedulerController::class, 'runNow'])->name('admin.system.scheduler.run');

        Route::get('/system/backups', [App\Http\Controllers\Admin\System\BackupsController::class, 'index'])->name('admin.system.backups');
        Route::post('/system/backups/run', [App\Http\Controllers\Admin\System\BackupsController::class, 'run'])->name('admin.system.backups.run');

        // Feature flags
        Route::get('/system/feature-flags', [App\Http\Controllers\Admin\System\FeatureFlagsController::class, 'index'])->name('admin.system.flags');
        Route::post('/system/feature-flags/{flagKey}', [App\Http\Controllers\Admin\System\FeatureFlagsController::class, 'toggle'])->name('admin.system.flags.toggle');
    });
