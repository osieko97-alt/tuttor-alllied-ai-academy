@extends('layouts.marketing')

@section('title', 'Tracks')

@section('content')
    <div style="text-align: center; margin-bottom: var(--space-8);">
        <h1 class="h1">Choose Your Track</h1>
        <p class="p" style="font-size: var(--text-lg); max-width: 600px; margin: var(--space-4) auto 0;">
            Three paths to deployment. Pick the one that matches your experience.
        </p>
    </div>

    <div class="grid grid-3">
        <!-- Coding Green -->
        <x-ui.card>
            <x-ui.badge kind="success">Beginner</x-ui.badge>
            <h2 class="h2" style="margin-top: var(--space-3);">Coding Green</h2>
            <p class="p" style="margin-top: var(--space-2);">
                Start from zero. Learn the workflow, ship your first MVP.
            </p>
            <div style="margin-top: var(--space-4); padding: var(--space-4); background: var(--bg); border-radius: var(--radius-lg);">
                <div style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--primary);">14</div>
                <div class="text-muted text-small">Days</div>
            </div>
            <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted);">
                <li>No experience required</li>
                <li>Git & GitHub fundamentals</li>
                <li>HTML, CSS, JavaScript basics</li>
                <li>Deploy to Vercel/Netlify</li>
                <li>Daily mentor check-ins</li>
            </ul>
            <div style="margin-top: var(--space-4);">
                <x-ui.button href="/tracks/coding-green" variant="primary" style="width: 100%;">Enroll Now</x-ui.button>
            </div>
        </x-ui.card>

        <!-- Aware but Stuck -->
        <x-ui.card>
            <x-ui.badge kind="warning">Intermediate</x-ui.badge>
            <h2 class="h2" style="margin-top: var(--space-3);">Aware but Stuck</h2>
            <p class="p" style="margin-top: var(--space-2);">
                You know basics but can't finish. We structure your sprint.
            </p>
            <div style="margin-top: var(--space-4); padding: var(--space-4); background: var(--bg); border-radius: var(--radius-lg);">
                <div style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--warning);">14</div>
                <div class="text-muted text-small">Days</div>
            </div>
            <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted);">
                <li>Basic coding knowledge</li>
                <li>Project scoping & planning</li>
                <li>Code review process</li>
                <li>CI/CD pipeline setup</li>
                <li>Professional feedback</li>
            </ul>
            <div style="margin-top: var(--space-4);">
                <x-ui.button href="/tracks/aware-but-stuck" variant="primary" style="width: 100%;">Enroll Now</x-ui.button>
            </div>
        </x-ui.card>

        <!-- Expert -->
        <x-ui.card>
            <x-ui.badge kind="info">Advanced</x-ui.badge>
            <h2 class="h2" style="margin-top: var(--space-3);">Expert</h2>
            <p class="p" style="margin-top: var(--space-2);">
                Ship faster, mentor others, and build your portfolio.
            </p>
            <div style="margin-top: var(--space-4); padding: var(--space-4); background: var(--bg); border-radius: var(--radius-lg);">
                <div style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--info);">14</div>
                <div class="text-muted text-small">Days</div>
            </div>
            <ul style="margin-top: var(--space-4); padding-left: var(--space-4); color: var(--muted);">
                <li>Professional experience</li>
                <li>Open source contributions</li>
                <li>Mentorship training</li>
                <li>Career guidance</li>
                <li>Network access</li>
            </ul>
            <div style="margin-top: var(--space-4);">
                <x-ui.button href="/tracks/expert" variant="primary" style="width: 100%;">Enroll Now</x-ui.button>
            </div>
        </x-ui.card>
    </div>

    <!-- Comparison Table -->
    <div style="margin-top: var(--space-10);">
        <h2 class="h2" style="margin-bottom: var(--space-6);">Compare Tracks</h2>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Coding Green</th>
                        <th>Aware but Stuck</th>
                        <th>Expert</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Daily Tasks</td>
                        <td>✅</td>
                        <td>✅</td>
                        <td>✅</td>
                    </tr>
                    <tr>
                        <td>GitHub Integration</td>
                        <td>✅</td>
                        <td>✅</td>
                        <td>✅</td>
                    </tr>
                    <tr>
                        <td>Code Reviews</td>
                        <td>2 per day</td>
                        <td>Unlimited</td>
                        <td>Unlimited + mentorship</td>
                    </tr>
                    <tr>
                        <td>Deploy Checklist</td>
                        <td>✅</td>
                        <td>✅</td>
                        <td>✅</td>
                    </tr>
                    <tr>
                        <td>Certificate</td>
                        <td>✅</td>
                        <td>✅</td>
                        <td>✅</td>
                    </tr>
                    <tr>
                        <td>Incubation Access</td>
                        <td>❌</td>
                        <td>✅</td>
                        <td>✅</td>
                    </tr>
                    <tr>
                        <td>Mentorship</td>
                        <td>Group</td>
                        <td>1-on-1</td>
                        <td>1-on-1 + peer</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
