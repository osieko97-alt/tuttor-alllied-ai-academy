@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 class="h1">Admin Dashboard</h1>
            <p class="p">System overview and quick actions.</p>
        </div>
        <div style="display: flex; gap: var(--space-3);">
            <x-ui.button href="/admin/system/health" variant="secondary">Health Check</x-ui.button>
            <x-ui.button href="/admin/integrations" variant="primary">Integrations</x-ui.button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-4">
        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-lg" style="background: var(--primary);">👥</div>
                <div>
                    <div class="text-muted text-small">Total Users</div>
                    <div class="h2">1,234</div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-lg" style="background: var(--success);">🚀</div>
                <div>
                    <div class="text-muted text-small">Active Sprints</div>
                    <div class="h2">89</div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-lg" style="background: var(--accent);">🏢</div>
                <div>
                    <div class="text-muted text-small">Incubation Projects</div>
                    <div class="h2">45</div>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center gap-4">
                <div class="avatar avatar-lg" style="background: var(--warning);">🏆</div>
                <div>
                    <div class="text-muted text-small">Graduations</div>
                    <div class="h2">156</div>
                </div>
            </div>
        </x-ui.card>
    </div>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: var(--space-6); margin-top: var(--space-6);">
        <!-- Recent Activity -->
        <x-ui.card>
            <h3 class="h3">Recent Activity</h3>
            <div style="margin-top: var(--space-4);">
                @for($i = 1; $i <= 5; $i++)
                    <div style="display: flex; gap: var(--space-3); padding: var(--space-3) 0; border-bottom: 1px solid var(--border);">
                        <div class="avatar avatar-sm">U{{ $i }}</div>
                        <div style="flex: 1;">
                            <div class="text-small">
                                <strong>User {{ $i }}</strong> started a new sprint
                            </div>
                            <div class="text-muted text-small">{{ $i * 5 }} minutes ago</div>
                        </div>
                    </div>
                @endfor
            </div>
        </x-ui.card>

        <!-- Quick Links -->
        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
            <x-ui.card>
                <h4 class="h4">Content Management</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3);">
                    <a href="/admin/tracks" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">📚 Tracks</a>
                    <a href="/admin/courses" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">🎓 Courses</a>
                    <a href="/admin/deploy-templates" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">✅ Deploy Templates</a>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h4 class="h4">Moderation</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3);">
                    <a href="/admin/moderation" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">🛡️ Moderation Queue</a>
                    <a href="/admin/partners/verification" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">✓ Partner Verifications</a>
                    <a href="/admin/projects/reports" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">🚨 Project Reports</a>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h4 class="h4">System</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3);">
                    <a href="/admin/system/jobs" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">⚙️ Jobs Queue</a>
                    <a href="/admin/system/backups" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">💾 Backups</a>
                    <a href="/admin/system/feature-flags" class="btn btn-ghost btn-sm" style="justify-content: flex-start;">🚩 Feature Flags</a>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection
