<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Tutor & Allied AI Academy - Full Route Map
| https://Tutor-Allied.dev
|
*/

// =============================================================================
// PUBLIC ROUTES
// =============================================================================

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Tracks
Route::get('/tracks', [App\Http\Controllers\TracksController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{slug}', [App\Http\Controllers\TracksController::class, 'show'])->name('tracks.show');

// Courses (public browse)
Route::get('/courses', [App\Http\Controllers\Courses\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [App\Http\Controllers\Courses\CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{slug}/lessons/{lessonSlug}', [App\Http\Controllers\Courses\LessonController::class, 'preview'])->name('courses.lesson.preview');

// Incubation (public directory + project pages)
Route::get('/incubation', [App\Http\Controllers\Incubation\ProjectController::class, 'index'])->name('incubation.index');
Route::get('/incubation/{projectSlug}', [App\Http\Controllers\Incubation\ProjectController::class, 'show'])->name('incubation.show');

// Partners (public directory + profiles + sessions/programs)
Route::get('/partners', [App\Http\Controllers\Partners\PartnerDirectoryController::class, 'index'])->name('partners.index');
Route::get('/partners/org/{slug}', [App\Http\Controllers\Partners\OrgController::class, 'showPublic'])->name('partners.org.show');
Route::get('/partners/people/{username}', [App\Http\Controllers\Partners\PartnerUserController::class, 'showPublic'])->name('partners.people.show');
Route::get('/partners/sessions', [App\Http\Controllers\Partners\SessionController::class, 'indexPublic'])->name('partners.sessions.index');
Route::get('/partners/sessions/{slug}', [App\Http\Controllers\Partners\SessionController::class, 'showPublic'])->name('partners.sessions.show');
Route::get('/partners/programs', [App\Http\Controllers\Partners\ProgramController::class, 'indexPublic'])->name('partners.programs.index');
Route::get('/partners/challenges', [App\Http\Controllers\Partners\ChallengeController::class, 'indexPublic'])->name('partners.challenges.index');

// Forum (read-only public)
Route::get('/forum', [App\Http\Controllers\Forum\ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/categories/{slug}', [App\Http\Controllers\Forum\ForumController::class, 'category'])->name('forum.category');
Route::get('/forum/threads/{slug}', [App\Http\Controllers\Forum\ThreadController::class, 'show'])->name('forum.thread.show');

// Blog
Route::get('/blog', [App\Http\Controllers\Blog\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [App\Http\Controllers\Blog\PostController::class, 'show'])->name('blog.post.show');

// AI CTA coming soon
Route::get('/ai', [App\Http\Controllers\AI\ComingSoonController::class, 'index'])->name('ai.comingsoon');

// Legal
Route::get('/terms', [App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms');
Route::get('/privacy', [App\Http\Controllers\LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/code-of-conduct', [App\Http\Controllers\LegalController::class, 'conduct'])->name('legal.conduct');

// =============================================================================
// AUTH ROUTES (Google + GitHub OAuth)
// =============================================================================

Route::get('/auth/google/redirect', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::get('/auth/github/redirect', [App\Http\Controllers\Auth\GitHubAuthController::class, 'redirect'])->name('auth.github.redirect');
Route::get('/auth/github/callback', [App\Http\Controllers\Auth\GitHubAuthController::class, 'callback'])->name('auth.github.callback');

// Laravel Breeze/Fortify auth routes (if installed)
// Auth::routes();

// =============================================================================
// AUTHENTICATED ROUTES (Student App)
// =============================================================================

Route::middleware(['auth'])->group(function () {

    // -------------------------------------------------------------------------
    // Onboarding Wizard
    // -------------------------------------------------------------------------
    Route::get('/onboarding', [App\Http\Controllers\OnboardingController::class, 'start'])->name('onboarding.start');
    Route::post('/onboarding/role', [App\Http\Controllers\OnboardingController::class, 'saveRole'])->name('onboarding.role');
    Route::post('/onboarding/profile', [App\Http\Controllers\OnboardingController::class, 'saveProfile'])->name('onboarding.profile');
    Route::post('/onboarding/linking', [App\Http\Controllers\OnboardingController::class, 'saveLinking'])->name('onboarding.linking');
    Route::post('/onboarding/finish', [App\Http\Controllers\OnboardingController::class, 'finish'])->name('onboarding.finish');

    // -------------------------------------------------------------------------
    // Dashboard
    // -------------------------------------------------------------------------
    Route::get('/app', [App\Http\Controllers\DashboardController::class, 'index'])->name('app.dashboard');

    // -------------------------------------------------------------------------
    // Learn Hub
    // -------------------------------------------------------------------------
    Route::get('/learn', [App\Http\Controllers\Learn\LearnHubController::class, 'index'])->name('learn.index');
    Route::post('/learn/enroll', [App\Http\Controllers\Learn\EnrollController::class, 'store'])->name('learn.enroll');
    Route::get('/learn/enrollment/{enrollmentId}', [App\Http\Controllers\Learn\EnrollController::class, 'show'])->name('learn.enrollment.show');

    // Day View
    Route::get('/learn/enrollment/{enrollmentId}/day/{dayNumber}', [App\Http\Controllers\Learn\DayController::class, 'show'])->name('learn.day.show');
    Route::post('/learn/enrollment/{enrollmentId}/day/{dayNumber}/tasks', [App\Http\Controllers\Learn\DayController::class, 'saveTasks'])->name('learn.day.tasks');
    Route::post('/learn/enrollment/{enrollmentId}/day/{dayNumber}/submit', [App\Http\Controllers\Learn\DayController::class, 'submitProof'])->name('learn.day.submit');
    Route::post('/learn/enrollment/{enrollmentId}/day/{dayNumber}/complete', [App\Http\Controllers\Learn\DayController::class, 'completeDay'])->name('learn.day.complete');

    // Deploy Checklist
    Route::get('/deploy', [App\Http\Controllers\Deploy\DeployChecklistController::class, 'index'])->name('deploy.index');
    Route::post('/deploy/items/{itemId}/toggle', [App\Http\Controllers\Deploy\DeployChecklistController::class, 'toggleItem'])->name('deploy.item.toggle');
    Route::post('/deploy/evidence', [App\Http\Controllers\Deploy\DeployChecklistController::class, 'saveEvidence'])->name('deploy.evidence');

    // Link Project to Enrollment (required for graduation)
    Route::get('/learn/enrollment/{enrollmentId}/link-project', [App\Http\Controllers\Learn\ProjectLinkController::class, 'show'])->name('learn.linkproject.show');
    Route::post('/learn/enrollment/{enrollmentId}/link-project', [App\Http\Controllers\Learn\ProjectLinkController::class, 'store'])->name('learn.linkproject.store');

    // Graduation
    Route::get('/graduation', [App\Http\Controllers\Learn\GraduationController::class, 'index'])->name('graduation.index');
    Route::post('/graduation/{enrollmentId}/graduate', [App\Http\Controllers\Learn\GraduationController::class, 'graduate'])->name('graduation.graduate');
    Route::get('/certificate/{enrollmentId}', [App\Http\Controllers\Learn\GraduationController::class, 'certificate'])->name('certificate.show');

    // -------------------------------------------------------------------------
    // Incubation Routes (projects + GitHub evidence loop)
    // -------------------------------------------------------------------------
    Route::get('/incubation/create', [App\Http\Controllers\Incubation\ProjectController::class, 'create'])->name('incubation.create');
    Route::post('/incubation', [App\Http\Controllers\Incubation\ProjectController::class, 'store'])->name('incubation.store');
    Route::get('/incubation/{projectSlug}/edit', [App\Http\Controllers\Incubation\ProjectController::class, 'edit'])->name('incubation.edit');
    Route::put('/incubation/{projectSlug}', [App\Http\Controllers\Incubation\ProjectController::class, 'update'])->name('incubation.update');

    // Reviews (PR/commit evidence)
    Route::post('/incubation/{projectSlug}/reviews', [App\Http\Controllers\Incubation\ReviewController::class, 'store'])->name('incubation.reviews.store');
    Route::post('/incubation/{projectSlug}/reviews/{reviewId}/implemented', [App\Http\Controllers\Incubation\ReviewController::class, 'markImplemented'])->name('incubation.reviews.implemented');
    Route::post('/incubation/{projectSlug}/reviews/{reviewId}/verify', [App\Http\Controllers\Incubation\ReviewController::class, 'verify'])->name('incubation.reviews.verify');

    // Team
    Route::get('/incubation/{projectSlug}/team', [App\Http\Controllers\Incubation\TeamController::class, 'index'])->name('incubation.team.index');
    Route::post('/incubation/{projectSlug}/team/requests', [App\Http\Controllers\Incubation\TeamController::class, 'requestJoin'])->name('incubation.team.request');
    Route::post('/incubation/{projectSlug}/team/requests/{requestId}/approve', [App\Http\Controllers\Incubation\TeamController::class, 'approve'])->name('incubation.team.approve');
    Route::post('/incubation/{projectSlug}/team/requests/{requestId}/reject', [App\Http\Controllers\Incubation\TeamController::class, 'reject'])->name('incubation.team.reject');

    // Updates (build logs)
    Route::post('/incubation/{projectSlug}/updates', [App\Http\Controllers\Incubation\UpdateController::class, 'store'])->name('incubation.updates.store');

    // -------------------------------------------------------------------------
    // Forum Routes (logged-in posting)
    // -------------------------------------------------------------------------
    Route::post('/forum/threads', [App\Http\Controllers\Forum\ThreadController::class, 'store'])->name('forum.thread.store');
    Route::post('/forum/threads/{threadSlug}/posts', [App\Http\Controllers\Forum\PostController::class, 'store'])->name('forum.post.store');
    Route::post('/forum/posts/{postId}/react', [App\Http\Controllers\Forum\PostController::class, 'react'])->name('forum.post.react');
    Route::post('/forum/threads/{threadSlug}/subscribe', [App\Http\Controllers\Forum\SubscriptionController::class, 'subscribe'])->name('forum.subscribe');
    Route::post('/forum/reports', [App\Http\Controllers\Forum\ForumController::class, 'report'])->name('forum.report');

    // -------------------------------------------------------------------------
    // Chat Routes (channels + messages)
    // -------------------------------------------------------------------------
    Route::get('/chat', [App\Http\Controllers\Chat\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/channels/{channelSlug}', [App\Http\Controllers\Chat\ChannelController::class, 'show'])->name('chat.channel.show');
    Route::post('/chat/channels/{channelSlug}/messages', [App\Http\Controllers\Chat\MessageController::class, 'store'])->name('chat.message.store');
    Route::post('/chat/messages/{messageId}/react', [App\Http\Controllers\Chat\MessageController::class, 'react'])->name('chat.message.react');
    Route::post('/chat/reports', [App\Http\Controllers\Chat\ChatController::class, 'report'])->name('chat.report');
    Route::post('/chat/dm/start', [App\Http\Controllers\Chat\DMController::class, 'start'])->name('chat.dm.start');
    Route::get('/chat/dm/{threadId}', [App\Http\Controllers\Chat\DMController::class, 'show'])->name('chat.dm.show');
    Route::post('/chat/dm/{threadId}/messages', [App\Http\Controllers\Chat\DMController::class, 'send'])->name('chat.dm.send');

    // -------------------------------------------------------------------------
    // Partners Routes (B: org + individual)
    // -------------------------------------------------------------------------
    Route::get('/partners/apply', [App\Http\Controllers\Partners\PartnerDirectoryController::class, 'apply'])->name('partners.apply');
    Route::post('/partners/apply/org', [App\Http\Controllers\Partners\OrgController::class, 'store'])->name('partners.apply.org');
    Route::post('/partners/apply/individual', [App\Http\Controllers\Partners\PartnerUserController::class, 'store'])->name('partners.apply.individual');
    Route::post('/partners/verification-request', [App\Http\Controllers\Partners\PartnerDirectoryController::class, 'requestVerification'])->name('partners.verify.request');

    Route::get('/partner', [App\Http\Controllers\Partners\PartnerDirectoryController::class, 'dashboard'])->name('partner.dashboard');

    // Programs
    Route::get('/partner/programs', [App\Http\Controllers\Partners\ProgramController::class, 'index'])->name('partner.programs.index');
    Route::get('/partner/programs/create', [App\Http\Controllers\Partners\ProgramController::class, 'create'])->name('partner.programs.create');
    Route::post('/partner/programs', [App\Http\Controllers\Partners\ProgramController::class, 'store'])->name('partner.programs.store');
    Route::get('/partner/programs/{programId}/applications', [App\Http\Controllers\Partners\ApplicationController::class, 'index'])->name('partner.programs.applications');
    Route::post('/partner/programs/{programId}/applications/{applicationId}/status', [App\Http\Controllers\Partners\ApplicationController::class, 'setStatus'])->name('partner.programs.applications.status');

    // Sessions
    Route::get('/partner/sessions', [App\Http\Controllers\Partners\SessionController::class, 'index'])->name('partner.sessions.index');
    Route::get('/partner/sessions/create', [App\Http\Controllers\Partners\SessionController::class, 'create'])->name('partner.sessions.create');
    Route::post('/partner/sessions', [App\Http\Controllers\Partners\SessionController::class, 'store'])->name('partner.sessions.store');
    Route::get('/partner/sessions/{sessionId}', [App\Http\Controllers\Partners\SessionController::class, 'show'])->name('partner.sessions.show');
    Route::post('/partner/sessions/{sessionId}/artifacts', [App\Http\Controllers\Partners\SessionController::class, 'addArtifact'])->name('partner.sessions.artifacts');
    Route::post('/partner/sessions/{sessionId}/projects', [App\Http\Controllers\Partners\SessionController::class, 'attachProject'])->name('partner.sessions.projects');

    // Public registration for sessions (logged-in users)
    Route::post('/partners/sessions/{sessionSlug}/register', [App\Http\Controllers\Partners\SessionController::class, 'register'])->name('partner.sessions.register');
    Route::post('/partners/sessions/{sessionSlug}/cancel', [App\Http\Controllers\Partners\SessionController::class, 'cancelRegistration'])->name('partner.sessions.cancel');

    // Mentorship
    Route::get('/partner/mentorship/offers', [App\Http\Controllers\Partners\MentorshipController::class, 'offers'])->name('partner.mentorship.offers');
    Route::get('/partner/mentorship/offers/create', [App\Http\Controllers\Partners\MentorshipController::class, 'createOffer'])->name('partner.mentorship.offers.create');
    Route::post('/partner/mentorship/offers', [App\Http\Controllers\Partners\MentorshipController::class, 'storeOffer'])->name('partner.mentorship.offers.store');
    Route::post('/partner/mentorship/offers/{offerId}/slots', [App\Http\Controllers\Partners\MentorshipController::class, 'createSlots'])->name('partner.mentorship.slots.create');
    Route::get('/partner/mentorship/bookings', [App\Http\Controllers\Partners\MentorshipController::class, 'bookings'])->name('partner.mentorship.bookings');
    Route::post('/partner/mentorship/bookings/{bookingId}/outcome', [App\Http\Controllers\Partners\MentorshipController::class, 'saveOutcome'])->name('partner.mentorship.outcome');

    // Mentorship booking (student side)
    Route::get('/mentorship', [App\Http\Controllers\Partners\MentorshipController::class, 'browse'])->name('mentorship.browse');
    Route::post('/mentorship/slots/{slotId}/book', [App\Http\Controllers\Partners\MentorshipController::class, 'book'])->name('mentorship.book');

    // Resources
    Route::get('/partner/resources', [App\Http\Controllers\Partners\ResourceController::class, 'index'])->name('partner.resources.index');
    Route::get('/partner/resources/create', [App\Http\Controllers\Partners\ResourceController::class, 'create'])->name('partner.resources.create');
    Route::post('/partner/resources', [App\Http\Controllers\Partners\ResourceController::class, 'store'])->name('partner.resources.store');
    Route::get('/partner/resources/requests', [App\Http\Controllers\Partners\ResourceController::class, 'requests'])->name('partner.resources.requests');
    Route::post('/partner/resources/requests/{requestId}/approve', [App\Http\Controllers\Partners\ResourceController::class, 'approve'])->name('partner.resources.approve');
    Route::post('/partner/resources/requests/{requestId}/reject', [App\Http\Controllers\Partners\ResourceController::class, 'reject'])->name('partner.resources.reject');

    // Pledges (tracking only)
    Route::get('/partner/pledges', [App\Http\Controllers\Partners\PledgeController::class, 'index'])->name('partner.pledges.index');
    Route::get('/partner/pledges/create', [App\Http\Controllers\Partners\PledgeController::class, 'create'])->name('partner.pledges.create');
    Route::post('/partner/pledges', [App\Http\Controllers\Partners\PledgeController::class, 'store'])->name('partner.pledges.store');
    Route::post('/partner/pledges/{pledgeId}/milestones', [App\Http\Controllers\Partners\PledgeController::class, 'addMilestone'])->name('partner.pledges.milestones');
    Route::post('/partner/pledges/{pledgeId}/milestones/{milestoneId}/review', [App\Http\Controllers\Partners\PledgeController::class, 'reviewMilestone'])->name('partner.pledges.milestone.review');

    // Challenges
    Route::get('/partner/challenges', [App\Http\Controllers\Partners\ChallengeController::class, 'index'])->name('partner.challenges.index');
    Route::get('/partner/challenges/create', [App\Http\Controllers\Partners\ChallengeController::class, 'create'])->name('partner.challenges.create');
    Route::post('/partner/challenges', [App\Http\Controllers\Partners\ChallengeController::class, 'store'])->name('partner.challenges.store');
    Route::get('/challenges/{challengeSlug}', [App\Http\Controllers\Partners\ChallengeController::class, 'showPublic'])->name('challenges.show');
    Route::post('/challenges/{challengeSlug}/submit', [App\Http\Controllers\Partners\ChallengeController::class, 'submit'])->name('challenges.submit');
});
