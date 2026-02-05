@extends('layouts.admin')

@section('title', "Webhook Logs - {$key}")

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 class="h1">Webhook Logs</h1>
            <p class="p">{{ ucfirst($key) }} webhook events.</p>
        </div>
        <div style="display: flex; gap: var(--space-2);">
            <a href="{{ route('admin.integrations.index') }}" class="btn btn-secondary btn-sm">
                ← Back to Integrations
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-4" style="margin-bottom: var(--space-6);">
        <x-ui.card>
            <div class="h3">{{ $stats['total'] }}</div>
            <div class="text-muted text-small">Total Events</div>
        </x-ui.card>
        <x-ui.card>
            <div class="h3">{{ $stats['received'] }}</div>
            <div class="text-muted text-small">Received</div>
        </x-ui.card>
        <x-ui.card>
            <div class="h3">{{ $stats['processed'] }}</div>
            <div class="text-muted text-small">Processed</div>
        </x-ui.card>
        <x-ui.card>
            <div class="h3">{{ $stats['failed'] }}</div>
            <div class="text-muted text-small">Failed</div>
        </x-ui.card>
    </div>

    <!-- Logs Table -->
    @if($logs->count() === 0)
        <x-ui.card>
            <p class="p">No webhook events logged yet.</p>
        </x-ui.card>
    @else
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Type</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>
                                <code style="font-size: var(--text-sm);">{{ $log->id }}</code>
                            </td>
                            <td>
                                {{ $log->event_type ?? 'Unknown' }}
                            </td>
                            <td>
                                @if($log->status === 'received')
                                    <x-ui.badge kind="info">Received</x-ui.badge>
                                @elseif($log->status === 'processed')
                                    <x-ui.badge kind="success">Processed</x-ui.badge>
                                @elseif($log->status === 'failed')
                                    <x-ui.badge kind="danger">Failed</x-ui.badge>
                                @else
                                    <x-ui.badge kind="default">Replayed</x-ui.badge>
                                @endif
                            </td>
                            <td>
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-2);">
                                    <button
                                        type="button"
                                        class="btn btn-ghost btn-sm"
                                        onclick="togglePayload({{ $log->id }})"
                                    >
                                        View Payload
                                    </button>
                                    @if($log->status === 'failed' || $log->status === 'processed')
                                        <form method="post" action="{{ route('admin.integrations.webhooks.replay', [$key, $log->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost btn-sm">
                                                Replay
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Hidden Payload -->
                                <div id="payload-{{ $log->id }}" style="display: none; margin-top: var(--space-3);">
                                    <pre style="background: var(--bg); padding: var(--space-3); border-radius: var(--radius-md); overflow-x: auto; font-size: var(--text-sm);">{{ json_encode(json_decode($log->payload), JSON_PRETTY_PRINT) }}</pre>
                                    @if($log->error_message)
                                        <div style="margin-top: var(--space-2); padding: var(--space-2); background: var(--danger-light); border-radius: var(--radius-sm); color: var(--danger);">
                                            <strong>Error:</strong> {{ $log->error_message }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: var(--space-6);">
            {{ $logs->links() }}
        </div>
    @endif

    <script>
        function togglePayload(id) {
            const el = document.getElementById('payload-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
