@extends('layouts.app')
@section('title', 'Graduation')

@section('content')
    <x-ui.card>
        <div class="h2">Graduation</div>
        <p class="p">
            Track: <strong>{{ $enrollment->track->name ?? 'Sprint' }}</strong>
            • Enrollment #{{ $enrollment->id }}
        </p>
    </x-ui.card>

    <div style="height: var(--space-6);"></div>

    @if($result['eligible'])
        <x-ui.card>
            <x-ui.badge kind="success">Ready</x-ui.badge>
            <div class="h2" style="margin-top: var(--space-3);">You're ready to graduate 🎉</div>
            <p class="p">Click below to generate your certificate.</p>

            <form method="post" action="{{ route('graduation.graduate', $enrollment->id) }}">
                @csrf
                <x-ui.button variant="primary" type="submit" style="margin-top: var(--space-4);">
                    Graduate Now
                </x-ui.button>
            </form>
        </x-ui.card>
    @else
        <x-ui.card>
            <x-ui.badge kind="warning">Not yet</x-ui.badge>
            <div class="h2" style="margin-top: var(--space-3);">Complete these to graduate</div>
            <p class="p">We'll unlock graduation automatically once you finish them.</p>

            <div style="margin-top: var(--space-6);">
                @foreach($result['missing'] as $m)
                    <div class="card" style="box-shadow: none; margin-top: var(--space-4); padding: var(--space-4); background: var(--bg);">
                        <strong>{{ $m['label'] }}</strong>
                        <p class="p" style="margin-top: var(--space-2);">{{ $m['detail'] }}</p>
                        <div style="margin-top: var(--space-3);">
                            <x-ui.button href="{{ $m['action_url'] }}" variant="primary">
                                Fix this
                            </x-ui.button>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    @endif

    <!-- Progress Summary -->
    <div class="card" style="margin-top: var(--space-6);">
        <h4 class="h4">Your Progress Summary</h4>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-4); margin-top: var(--space-4);">
            <div style="text-align: center;">
                <div class="h3">{{ $result['summary']['days_completed'] ?? 0 }}</div>
                <div class="text-muted text-small">Days Completed</div>
            </div>
            <div style="text-align: center;">
                <div class="h3">{{ $result['summary']['deploy_done'] ?? 0 }}/{{ $result['summary']['deploy_total'] ?? 0 }}</div>
                <div class="text-muted text-small">Deploy Items</div>
            </div>
            <div style="text-align: center;">
                <div class="h3">{{ $enrollment->linked_project_id ? 'Yes' : 'No' }}</div>
                <div class="text-muted text-small">Project Linked</div>
            </div>
        </div>
    </div>
@endsection
