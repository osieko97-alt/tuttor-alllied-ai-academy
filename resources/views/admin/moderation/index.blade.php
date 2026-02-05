@extends('layouts.admin')

@section('title', 'Moderation Queue')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 class="h1">Moderation Queue</h1>
            <p class="p">Review and act on user reports.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-4" style="margin-bottom: var(--space-6);">
        <a href="?status=pending" class="card" style="{{ $status === 'pending' ? 'border-color: var(--primary);' : '' }}">
            <div class="h2">{{ $stats['pending'] }}</div>
            <div class="text-muted text-small">Pending</div>
        </a>
        <a href="?status=reviewed" class="card" style="{{ $status === 'reviewed' ? 'border-color: var(--primary);' : '' }}">
            <div class="h2">{{ $stats['reviewed'] }}</div>
            <div class="text-muted text-small">Reviewed</div>
        </a>
        <a href="?status=resolved" class="card" style="{{ $status === 'resolved' ? 'border-color: var(--primary);' : '' }}">
            <div class="h2">{{ $stats['resolved'] }}</div>
            <div class="text-muted text-small">Resolved</div>
        </a>
        <a href="?status=dismissed" class="card" style="{{ $status === 'dismissed' ? 'border-color: var(--primary);' : '' }}">
            <div class="h2">{{ $stats['dismissed'] }}</div>
            <div class="text-muted text-small">Dismissed</div>
        </a>
    </div>

    <!-- Filter -->
    <div class="card" style="margin-bottom: var(--space-6);">
        <form method="get" style="display: flex; gap: var(--space-4); align-items: center;">
            <input type="hidden" name="status" value="{{ $status }}">
            <div>
                <label class="text-small">Type</label>
                <select name="type" class="input" style="margin-top: var(--space-1);">
                    <option value="">All Types</option>
                    <option value="forum_post" {{ $type === 'forum_post' ? 'selected' : '' }}>Forum Post</option>
                    <option value="forum_thread" {{ $type === 'forum_thread' ? 'selected' : '' }}>Forum Thread</option>
                    <option value="chat_message" {{ $type === 'chat_message' ? 'selected' : '' }}>Chat Message</option>
                    <option value="project" {{ $type === 'project' ? 'selected' : '' }}>Project</option>
                    <option value="review" {{ $type === 'review' ? 'selected' : '' }}>Review</option>
                </select>
            </div>
            <x-ui.button variant="primary" type="submit" style="margin-top: var(--space-5);">Filter</x-ui.button>
        </form>
    </div>

    <!-- Reports List -->
    @if($reports->count() === 0)
        <x-ui.card>
            <p class="p">No reports found in this queue.</p>
        </x-ui.card>
    @else
        @foreach($reports as $report)
            <x-ui.card style="margin-bottom: var(--space-4);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--space-4);">
                    <div style="flex: 1;">
                        <div style="display: flex; gap: var(--space-2); align-items: center; margin-bottom: var(--space-2);">
                            <x-ui.badge>{{ ucfirst(str_replace('_', ' ', $report->report_type)) }}</x-ui.badge>
                            @if($report->status === 'pending')
                                <x-ui.badge kind="warning">Pending</x-ui.badge>
                            @elseif($report->status === 'resolved')
                                <x-ui.badge kind="success">Resolved</x-ui.badge>
                            @else
                                <x-ui.badge kind="default">Dismissed</x-ui.badge>
                            @endif
                        </div>

                        <p class="p"><strong>Reported by:</strong> {{ $report->reporter_name ?? 'Unknown' }}</p>
                        @if($report->moderator_name)
                            <p class="p"><strong>Reviewed by:</strong> {{ $report->moderator_name }}</p>
                        @endif
                        <p class="p"><strong>Reason:</strong> {{ $report->reason ?? 'No reason provided' }}</p>
                        <p class="p text-small text-muted">{{ $report->created_at->diffForHumans() }}</p>

                        @if($report->moderator_notes)
                            <div style="margin-top: var(--space-3); padding: var(--space-3); background: var(--bg); border-radius: var(--radius-md);">
                                <p class="p text-small"><strong>Moderator Notes:</strong> {{ $report->moderator_notes }}</p>
                            </div>
                        @endif
                    </div>

                    @if($report->status === 'pending')
                        <div style="display: flex; flex-direction: column; gap: var(--space-2);">
                            <form method="post" action="{{ route('admin.moderation.action') }}">
                                @csrf
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <input type="hidden" name="action" value="resolve">
                                <x-ui.button variant="success" size="sm" type="submit">Resolve</x-ui.button>
                            </form>
                            <form method="post" action="{{ route('admin.moderation.action') }}">
                                @csrf
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <input type="hidden" name="action" value="dismiss">
                                <x-ui.button variant="secondary" size="sm" type="submit">Dismiss</x-ui.button>
                            </form>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        @endforeach

        <div style="margin-top: var(--space-6);">
            {{ $reports->appends(['status' => $status, 'type' => $type])->links() }}
        </div>
    @endif
@endsection
