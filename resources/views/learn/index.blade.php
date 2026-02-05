@extends('layouts.app')

@section('title', 'Learn Hub')

@section('content')
    <div style="margin-bottom: var(--space-6);">
        <h1 class="h1">Learn Hub</h1>
        <p class="p">Your learning journey. Track progress, complete daily tasks, and deploy your project.</p>
    </div>

    <!-- Current Enrollment -->
    <x-ui.card style="margin-bottom: var(--space-6);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--space-6); flex-wrap: wrap;">
            <div style="flex: 1;">
                <x-ui.badge kind="success">Active Sprint</x-ui.badge>
                <h2 class="h2" style="margin-top: var(--space-2);">Coding Green - My SaaS MVP</h2>
                <p class="p">Started 7 days ago • 6 days remaining</p>
            </div>
            <div style="text-align: right;">
                <div class="h2">50%</div>
                <div class="text-muted text-small">Complete</div>
            </div>
        </div>

        <div style="margin-top: var(--space-4);">
            <x-ui.progress :value="50" />
        </div>

        <div style="display: flex; gap: var(--space-3); margin-top: var(--space-4);">
            <x-ui.button href="/learn/enrollment/1" variant="primary">Continue Sprint</x-ui.button>
            <x-ui.button href="/learn/enrollment/1/day/7" variant="secondary">Day 7 Tasks</x-ui.button>
        </div>
    </x-ui.card>

    <!-- Enrolled Tracks -->
    <h3 class="h3" style="margin-bottom: var(--space-4);">Your Enrollments</h3>
    <div class="grid grid-3" style="margin-bottom: var(--space-8);">
        <x-ui.card>
            <x-ui.badge kind="success">In Progress</x-ui.badge>
            <h4 class="h4" style="margin-top: var(--space-2);">Coding Green</h4>
            <div class="text-muted text-small">Day 7 of 14</div>
            <x-ui.progress :value="50" style="margin-top: var(--space-3);" />
            <x-ui.button href="/learn/enrollment/1" variant="primary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                Continue
            </x-ui.button>
        </x-ui.card>

        <x-ui.card>
            <x-ui.badge kind="default">Completed</x-ui.badge>
            <h4 class="h4" style="margin-top: var(--space-2);">HTML & CSS Basics</h4>
            <div class="text-muted text-small">Graduated Jan 2024</div>
            <x-ui.progress :value="100" style="margin-top: var(--space-3);" />
            <x-ui.button href="/certificate/1" variant="secondary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                View Certificate
            </x-ui.button>
        </x-ui.card>
    </div>

    <!-- Available Tracks -->
    <h3 class="h3" style="margin-bottom: var(--space-4);">Available Tracks</h3>
    <div class="grid grid-3">
        <x-ui.card>
            <x-ui.badge kind="success">Beginner</x-ui.badge>
            <h4 class="h4" style="margin-top: var(--space-2);">Coding Green</h4>
            <p class="p text-small" style="margin-top: var(--space-2);">
                Start from zero. Learn the workflow, ship your first MVP.
            </p>
            <x-ui.button href="/tracks/coding-green" variant="primary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                Enroll
            </x-ui.button>
        </x-ui.card>

        <x-ui.card>
            <x-ui.badge kind="warning">Intermediate</x-ui.badge>
            <h4 class="h4" style="margin-top: var(--space-2);">Aware but Stuck</h4>
            <p class="p text-small" style="margin-top: var(--space-2);">
                You know basics but can't finish. We structure your sprint.
            </p>
            <x-ui.button href="/tracks/aware-but-stuck" variant="primary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                Enroll
            </x-ui.button>
        </x-ui.card>

        <x-ui.card>
            <x-ui.badge kind="info">Advanced</x-ui.badge>
            <h4 class="h4" style="margin-top: var(--space-2);">Expert</h4>
            <p class="p text-small" style="margin-top: var(--space-2);">
                Ship faster, mentor others, and build your portfolio.
            </p>
            <x-ui.button href="/tracks/expert" variant="primary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                Enroll
            </x-ui.button>
        </x-ui.card>
    </div>

    <!-- Graduation Status -->
    <div class="card" style="margin-top: var(--space-8); padding: var(--space-6); background: linear-gradient(135deg, var(--success-light) 0%, var(--surface) 100%); border-color: var(--success);">
        <div style="display: flex; align-items: center; gap: var(--space-4);">
            <div class="avatar avatar-lg" style="background: var(--success);">🏆</div>
            <div style="flex: 1;">
                <h3 class="h3">Ready to Graduate?</h3>
                <p class="p">Complete all requirements to earn your certificate.</p>
            </div>
            <x-ui.button href="/graduation" variant="success">Check Eligibility</x-ui.button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-4); margin-top: var(--space-6);">
            <div style="text-align: center;">
                <div style="font-size: var(--text-2xl); color: var(--success);">✓</div>
                <div class="text-small">All Days Complete</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: var(--text-2xl); color: var(--success);">✓</div>
                <div class="text-small">Deploy Checklist</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: var(--text-2xl); color: var(--success);">✓</div>
                <div class="text-small">Project Linked</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: var(--text-2xl); color: var(--warning);">○</div>
                <div class="text-small">1+ Reviews (0/1)</div>
            </div>
        </div>
    </div>
@endsection
