@extends('layouts.marketing')

@section('title', 'Deploy a real project in 14 days')

@section('content')
    <!-- Hero Section -->
    <div class="card" style="text-align: center; padding: var(--space-10) var(--space-6);">
        <x-ui.badge kind="primary">AI Academy</x-ui.badge>
        <h1 class="h1" style="margin-top: var(--space-4); margin-bottom: var(--space-4);">
            Deploy a real project in 14 days.
        </h1>
        <p class="p" style="font-size: var(--text-lg); max-width: 600px; margin: 0 auto var(--space-6);">
            For Coding Green beginners, stuck learners, and experts.
            Build with reviews, mentorship, and incubation support.
        </p>
        <div style="display: flex; gap: var(--space-3); justify-content: center; flex-wrap: wrap;">
            <x-ui.button href="/tracks" variant="primary" size="lg">Start 14-Day Sprint</x-ui.button>
            <x-ui.button href="/incubation" variant="secondary" size="lg">Explore Incubation</x-ui.button>
        </div>
    </div>

    <!-- Stats Strip -->
    <div class="grid grid-3" style="margin-top: var(--space-6);">
        <div class="card" style="text-align: center;">
            <div class="h2" style="color: var(--primary);">14</div>
            <div class="text-muted">Days to Deploy</div>
        </div>
        <div class="card" style="text-align: center;">
            <div class="h2" style="color: var(--accent);">3</div>
            <div class="text-muted">Tracks</div>
        </div>
        <div class="card" style="text-align: center;">
            <div class="h2" style="color: var(--success);">∞</div>
            <div class="text-muted">Projects Incubated</div>
        </div>
    </div>

    <!-- Tracks Section -->
    <div style="margin-top: var(--space-10);">
        <h2 class="h2" style="margin-bottom: var(--space-6);">Choose Your Track</h2>
        <div class="grid grid-3">
            <!-- Coding Green -->
            <x-ui.card>
                <x-ui.badge kind="success">Beginner</x-ui.badge>
                <h3 class="h3" style="margin-top: var(--space-3);">Coding Green</h3>
                <p class="p" style="margin-top: var(--space-2);">
                    Start from zero. Learn the workflow, ship your first MVP.
                </p>
                <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted); font-size: var(--text-sm);">
                    <li>No experience needed</li>
                    <li>Daily structured tasks</li>
                    <li>GitHub fundamentals</li>
                    <li>First deploy</li>
                </ul>
                <div style="margin-top: var(--space-4);">
                    <x-ui.button href="/tracks/coding-green" variant="primary" style="width: 100%;">Start Coding Green</x-ui.button>
                </div>
            </x-ui.card>

            <!-- Aware but Stuck -->
            <x-ui.card>
                <x-ui.badge kind="warning">Intermediate</x-ui.badge>
                <h3 class="h3" style="margin-top: var(--space-3);">Aware but Stuck</h3>
                <p class="p" style="margin-top: var(--space-2);">
                    You know basics but can't finish. We structure your sprint.
                </p>
                <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted); font-size: var(--text-sm);">
                    <li>Some coding experience</li>
                    <li>Project scoping</li>
                    <li>Code review process</li>
                    <li>Deployment pipeline</li>
                </ul>
                <div style="margin-top: var(--space-4);">
                    <x-ui.button href="/tracks/aware-but-stuck" variant="primary" style="width: 100%;">Start Aware but Stuck</x-ui.button>
                </div>
            </x-ui.card>

            <!-- Expert -->
            <x-ui.card>
                <x-ui.badge kind="info">Advanced</x-ui.badge>
                <h3 class="h3" style="margin-top: var(--space-3);">Expert</h3>
                <p class="p" style="margin-top: var(--space-2);">
                    Ship faster, mentor others, and build your portfolio.
                </p>
                <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted); font-size: var(--text-sm);">
                    <li>Professional experience</li>
                    <li>Open source contributions</li>
                    <li>Mentorship</li>
                    <li>Career acceleration</li>
                </ul>
                <div style="margin-top: var(--space-4);">
                    <x-ui.button href="/tracks/expert" variant="primary" style="width: 100%;">Start Expert Track</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- How It Works -->
    <div style="margin-top: var(--space-10);">
        <h2 class="h2" style="margin-bottom: var(--space-6); text-align: center;">How It Works</h2>
        <div class="grid grid-4">
            <x-ui.card style="text-align: center;">
                <div class="avatar avatar-lg" style="margin: 0 auto var(--space-3); background: var(--primary);">1</div>
                <h4 class="h4">Enroll</h4>
                <p class="p text-small">Choose your track and start your 14-day journey.</p>
            </x-ui.card>
            <x-ui.card style="text-align: center;">
                <div class="avatar avatar-lg" style="margin: 0 auto var(--space-3); background: var(--primary);">2</div>
                <h4 class="h4">Build</h4>
                <p class="p text-small">Complete daily tasks with GitHub evidence.</p>
            </x-ui.card>
            <x-ui.card style="text-align: center;">
                <div class="avatar avatar-lg" style="margin: 0 auto var(--space-3); background: var(--primary);">3</div>
                <h4 class="h4">Review</h4>
                <p class="p text-small">Get feedback from mentors and partners.</p>
            </x-ui.card>
            <x-ui.card style="text-align: center;">
                <div class="avatar avatar-lg" style="margin: 0 auto var(--space-3); background: var(--success);">4</div>
                <h4 class="h4">Deploy</h4>
                <p class="p text-small">Ship to production and graduate!</p>
            </x-ui.card>
        </div>
    </div>

    <!-- CTA -->
    <div class="card" style="margin-top: var(--space-10); text-align: center; padding: var(--space-8); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%); color: white;">
        <h2 class="h2" style="color: white;">Ready to build?</h2>
        <p class="p" style="color: rgba(255,255,255,0.9); margin-top: var(--space-2); max-width: 500px; margin-left: auto; margin-right: auto;">
            Join thousands of builders who shipped their first project in just 2 weeks.
        </p>
        <div style="margin-top: var(--space-6);">
            <x-ui.button href="/auth/google/redirect" variant="secondary" size="lg">
                Continue with Google
            </x-ui.button>
            <x-ui.button href="/auth/github/redirect" variant="secondary" size="lg" style="margin-left: var(--space-3);">
                Continue with GitHub
            </x-ui.button>
        </div>
    </div>
@endsection
