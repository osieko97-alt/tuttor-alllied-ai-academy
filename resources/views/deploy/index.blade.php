@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1>Deploy Checklist</h1>

  @if(!$enrollment)
    <div class="alert alert-info">Join a track to start your 14-day sprint and checklist.</div>
    <div class="mt-4">
      <a href="{{ route('tracks') }}" class="btn btn-primary">Browse Tracks</a>
    </div>
  @else
    <div class="card mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted">Current Track</div>
          <div class="fw-bold">{{ $enrollment->track_name ?? 'Track' }} - Day {{ $enrollment->current_day }} of 14</div>
        </div>
        <div>
          <span class="badge {{ $status==='deploy_ready' ? 'text-bg-success' : 'text-bg-secondary' }}">
            {{ strtoupper($status ?? 'in_progress') }}
          </span>
        </div>
      </div>
    </div>

    @if($status === 'deploy_ready')
      <div class="alert alert-success">
        <strong>🎉 Congratulations!</strong> You've completed all required checklist items and are ready to deploy!
      </div>
    @endif

    @if($groups->count() > 0)
      @foreach($groups as $groupName => $items)
        <div class="card mb-3">
          <div class="card-body">
            <h4 class="mb-3">{{ $groupName }}</h4>

            @php $doneCount = $items->where('is_done', true)->count(); @endphp
            <div class="progress mb-3" style="height: 8px;">
              <div class="progress-bar" role="progressbar" style="width: {{ ($doneCount / $items->count()) * 100 }}%"></div>
            </div>

            @foreach($items as $it)
              <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fw-bold">{{ $it->title }}</div>
                    @if($it->help_text)
                      <div class="text-muted small">{{ $it->help_text }}</div>
                    @endif
                    <div class="small text-muted mt-1">
                      @if($it->is_required) Required @else Optional @endif
                      @if($it->requires_repo) • Needs repo @endif
                      @if($it->requires_demo) • Needs demo @endif
                    </div>
                  </div>
                  <span class="badge {{ $it->is_done ? 'text-bg-success' : 'text-bg-warning' }}">
                    {{ $it->is_done ? 'DONE' : 'PENDING' }}
                  </span>
                </div>

                <form method="POST" action="{{ route('deploy.item.toggle',$it->id) }}" class="mt-2">
                  @csrf
                  <div class="row g-2">
                    <div class="col-md-6">
                      <input name="repo_url" class="form-control form-control-sm" placeholder="Repo URL (if needed)" value="{{ $it->repo_url }}">
                    </div>
                    <div class="col-md-6">
                      <input name="demo_url" class="form-control form-control-sm" placeholder="Demo URL (if needed)" value="{{ $it->demo_url }}">
                    </div>
                  </div>
                  <textarea name="notes" class="form-control form-control-sm mt-2" rows="2" placeholder="Notes (optional)">{{ $it->notes }}</textarea>
                  <button class="btn btn-sm {{ $it->is_done ? 'btn-outline-warning' : 'btn-outline-primary' }} mt-2">
                    {{ $it->is_done ? 'Mark as Pending' : 'Mark as Done' }}
                  </button>
                </form>
              </div>
            @endforeach

          </div>
        </div>
      @endforeach
    @else
      <div class="alert alert-warning">No checklist items found. Please enroll in a track first.</div>
    @endif
  @endif
</div>
@endsection
