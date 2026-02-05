@extends('layouts.app')
@section('title', 'Certificate')

@section('content')
    <div class="card" style="text-align: center; padding: var(--space-10);">
        <x-ui.badge kind="success">Certificate of Completion</x-ui.badge>

        <div class="h1" style="margin-top: var(--space-6); color: var(--primary);">
            Tutor & Allied AI Academy
        </div>

        <p class="p" style="margin-top: var(--space-6); font-size: var(--text-lg);">
            This certifies that
        </p>

        <div class="h1" style="margin-top: var(--space-4);">
            {{ auth()->user()->name }}
        </div>

        <p class="p" style="margin-top: var(--space-6); font-size: var(--text-lg);">
            has successfully completed the<br>
            <strong>{{ $enrollment->track->name ?? '14-Day Sprint' }}</strong><br>
            and deployed a project with community review.
        </p>

        <div style="margin-top: var(--space-8); padding: var(--space-6); background: var(--bg); border-radius: var(--radius-xl);">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-6); text-align: left;">
                <div>
                    <div class="text-muted text-small">Certificate Code</div>
                    <div style="font-family: var(--font-mono); font-size: var(--text-lg); font-weight: var(--font-bold);">
                        {{ $cert->certificate_code }}
                    </div>
                </div>
                <div>
                    <div class="text-muted text-small">Date Issued</div>
                    <div style="font-size: var(--text-lg);">
                        {{ \Carbon\Carbon::parse($cert->issued_at)->toFormattedDateString() }}
                    </div>
                </div>
            </div>

            @if($enrollment->linkedProject)
                <div style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--border);">
                    <div class="text-muted text-small">Graduation Project</div>
                    <div style="font-size: var(--text-xl); font-weight: var(--font-bold); margin-top: var(--space-2);">
                        {{ $enrollment->linkedProject->title ?? 'Incubation Project' }}
                    </div>
                    @if($enrollment->linkedProject->repo_url)
                        <a href="{{ $enrollment->linkedProject->repo_url }}" target="_blank" class="text-primary" style="margin-top: var(--space-2); display: inline-block;">
                            View on GitHub →
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div style="margin-top: var(--space-8); display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <x-ui.button href="/app" variant="secondary">
                Back to Dashboard
            </x-ui.button>
            <x-ui.button href="#" variant="primary">
                Download PDF
            </x-ui.button>
        </div>
    </div>

    <!-- Share Section -->
    <div class="card" style="margin-top: var(--space-6); text-align: center;">
        <h4 class="h4">Share Your Achievement</h4>
        <div style="display: flex; gap: var(--space-3); justify-content: center; margin-top: var(--space-4); flex-wrap: wrap;">
            <x-ui.button variant="secondary" size="sm">
                Share on Twitter
            </x-ui.button>
            <x-ui.button variant="secondary" size="sm">
                Share on LinkedIn
            </x-ui.button>
            <x-ui.button variant="secondary" size="sm">
                Copy Link
            </x-ui.button>
        </div>
    </div>
@endsection
