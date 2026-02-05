@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 class="h1">Dashboard</h1>
            <p class="p">Welcome back, {{ auth()->user()->name ?? 'Builder' }}!</p>
        </div>
        <x-ui.button href="/learn" variant="primary">Continue Learning</x-ui.button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-4" style="margin-bottom: var(--space-6);">
        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-md" style="background: var(--primary);">📚</div>
                <div>
                    <div class="text-muted text-small">Active Sprint</div>
                    <div class="h3">Day 7</div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-md" style="background: var(--success);">✓</div>
                <div>
                    <div class="text-muted text-small">Tasks Done</div>
                    <div class="h3">12/14</div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-md" style="background: var(--accent);">🚀</div>
                <div>
                    <div class="text-muted text-small">Deploy Status</div>
                    <x-ui.badge kind="warning">In Progress</x-ui.badge>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-md" style="background: var(--info);">🏆</div>
                <div>
                    <div class="text-muted text-small">Graduation</div>
                    <div class="h3">85%</div>
                </div>
            </div>
        </x-ui.card>
    </div>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: var(--space-6);">
        <!-- Current Sprint Progress -->
        <x-ui.card>
            <h3 class="h3">Current Sprint Progress</h3>
            <div style="margin-top: var(--space-4);">
                <div class="flex justify-between mb-2">
                    <span>Overall Completion</span>
                    <span class="font-semibold">50%</span>
                </div>
                <x-ui.progress :value="50" />
            </div>

            <div style="margin-top: var(--space-6);">
                <h4 class="h4">Day Overview</h4>
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: var(--space-2); margin-top: var(--space-3);">
                    @for($i = 1; $i <= 14; $i++)
                        @php
                            $status = $i < 7 ? 'success' : ($i == 7 ? 'warning' : 'default');
                            $icon = $i < 7 ? '✓' : ($i == 7 ? '•' : '○');
                        @endphp
                        <div class="card" style="padding: var(--space-3); text-align: center; {{ $status == 'success' ? 'background: var(--success-light);' : '' }}">
                            <div class="text-small text-muted">Day {{ $i }}</div>
                            <div style="font-size: var(--text-lg);">{{ $icon }}</div>
                        </div>
                    @endfor
                </div>
            </div>

            <div style="margin-top: var(--space-6);">
                <x-ui.button href="/learn/enrollment/1/day/7" variant="primary">Continue Day 7</x-ui.button>
            </div>
        </x-ui.card>

        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
            <!-- Linked Project -->
            <x-ui.card>
                <h4 class="h4">Linked Project</h4>
                <div style="margin-top: var(--space-3); padding: var(--space-3); background: var(--bg); border-radius: var(--radius-lg);">
                    <div class="text-small text-muted">My SaaS MVP</div>
                    <a href="#" class="text-small" style="color: var(--primary);">View on GitHub →</a>
                </div>
                <x-ui.button href="/learn/enrollment/1/link-project" variant="secondary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                    Change Project
                </x-ui.button>
            </x-ui.card>

            <!-- Deploy Checklist -->
            <x-ui.card>
                <h4 class="h4">Deploy Checklist</h4>
                <div style="margin-top: var(--space-3);">
                    <x-ui.progress :value="60" :showLabel="true" />
                </div>
                <div style="margin-top: var(--space-3); font-size: var(--text-sm);">
                    <div>✓ Domain configured</div>
                    <div>✓ SSL certificate</div>
                    <div>○ Database migrations</div>
                    <div>○ CI/CD pipeline</div>
                </div>
                <x-ui.button href="/deploy" variant="secondary" size="sm" style="width: 100%; margin-top: var(--space-3);">
                    View Checklist
                </x-ui.button>
            </x-ui.card>

            <!-- Quick Actions -->
            <x-ui.card>
                <h4 class="h4">Quick Actions</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3);">
                    <a href="/incubation" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">
                        🏢 Incubation Projects
                    </a>
                    <a href="/forum" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">
                        💬 Forum
                    </a>
                    <a href="/chat" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">
                        💭 Chat
                    </a>
                    <a href="/mentorship" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">
                        👨‍🏫 Find Mentor
                    </a>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection
