@extends('layouts.admin')

@section('title', 'Integrations')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 class="h1">Integrations Manager</h1>
            <p class="p">Configure and test system integrations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Integration Cards -->
    <div style="display: grid; gap: var(--space-4);">
        @forelse($integrations as $integration)
            <x-ui.card>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--space-4);">
                    <div style="flex: 1;">
                        <div style="display: flex; gap: var(--space-2); align-items: center; margin-bottom: var(--space-2);">
                            <h3 class="h3">{{ $integration->name }}</h3>
                            @if($integration->is_enabled)
                                <x-ui.badge kind="success">Enabled</x-ui.badge>
                            @else
                                <x-ui.badge kind="default">Disabled</x-ui.badge>
                            @endif
                        </div>
                        <p class="p">{{ $integration->description ?? 'No description' }}</p>

                        @if($integration->last_tested_at)
                            <div style="margin-top: var(--space-3); display: flex; gap: var(--space-4); font-size: var(--text-sm);">
                                <span class="text-muted">Last tested: {{ $integration->last_tested_at->diffForHumans() }}</span>
                                @if($integration->last_test_status === 'success')
                                    <span style="color: var(--success);">✓ Test passed</span>
                                @elseif($integration->last_test_status === 'failed')
                                    <span style="color: var(--danger);">✗ Test failed</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                        <a href="{{ route('admin.integrations.edit', $integration->key) }}" class="btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form method="post" action="{{ route('admin.integrations.test.run', $integration->key) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">
                                Test
                            </button>
                        </form>
                        @if($integration->is_enabled)
                            <form method="post" action="{{ route('admin.integrations.disable', $integration->key) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-sm">
                                    Disable
                                </button>
                            </form>
                        @else
                            <form method="post" action="{{ route('admin.integrations.enable', $integration->key) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Enable
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="p">No integrations configured yet.</p>
            </x-ui.card>
        @endforelse
    </div>

    <!-- Quick Help -->
    <div class="card" style="margin-top: var(--space-8);">
        <h4 class="h4">Webhook Endpoints</h4>
        <p class="p">Use these URLs in your provider dashboards:</p>

        <div style="margin-top: var(--space-4);">
            <div style="margin-bottom: var(--space-3);">
                <strong>GitHub:</strong>
                <code style="background: var(--bg); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); margin-left: var(--space-2);">
                    https://Tutor-Allied.dev/webhooks/github
                </code>
            </div>
            <div style="margin-bottom: var(--space-3);">
                <strong>SendGrid:</strong>
                <code style="background: var(--bg); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); margin-left: var(--space-2);">
                    https://Tutor-Allied.dev/webhooks/sendgrid
                </code>
            </div>
            <div>
                <strong>Pusher:</strong>
                <code style="background: var(--bg); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); margin-left: var(--space-2);">
                    https://Tutor-Allied.dev/webhooks/pusher
                </code>
            </div>
        </div>
    </div>
@endsection
