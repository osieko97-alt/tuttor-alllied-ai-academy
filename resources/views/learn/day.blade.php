@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 980px;">
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <a href="{{ route('learn.enrollment.show',$enrollment->id) }}" class="text-decoration-none">&larr; Back to sprint</a>

  <div class="d-flex justify-content-between align-items-start mt-2">
    <div>
      <h1 class="mb-1">Day {{ $day }} — {{ $trackDay->focus ?? 'Sprint Day' }}</h1>
      <div class="text-muted">{{ $enrollment->track_name }} • Complete tasks then submit proof.</div>
    </div>
    <div class="text-end">
      <span class="badge {{ $completion->is_completed ? 'text-bg-success' : 'text-bg-warning' }}">
        {{ $completion->is_completed ? 'COMPLETED' : 'IN PROGRESS' }}
      </span>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body">
      <h4>Tasks</h4>

      <form method="POST" action="{{ route('learn.day.tasks',[$enrollment->id,$day]) }}">
        @csrf

        @foreach($tasksState as $i => $t)
          <div class="form-check mb-2">
            <input class="form-check-input"
                   type="checkbox"
                   id="task{{ $i }}"
                   name="tasks_state[{{ $i }}][done]"
                   value="1"
                   {{ !empty($t['done']) ? 'checked' : '' }}
                   onchange="this.form.submit()">
            <label class="form-check-label" for="task{{ $i }}">
              {{ $t['text'] }}
            </label>

            <input type="hidden" name="tasks_state[{{ $i }}][text]" value="{{ $t['text'] }}">
            <input type="hidden" name="tasks_state[{{ $i }}][done]" value="0">
          </div>
        @endforeach

        <div class="text-muted small mt-2">
          Tip: when all tasks are checked, the day auto-marks complete and your sprint moves to the next day.
        </div>
      </form>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body">
      <h4>Submit Proof (Recommended)</h4>
      <p class="text-muted">Add notes or links to show what you built today.</p>

      <form method="POST" action="{{ route('learn.day.submit',[$enrollment->id,$day]) }}">
        @csrf
        <textarea name="notes" class="form-control mb-2" rows="3" placeholder="What did you build today?">{{ $submission->notes ?? '' }}</textarea>

        <div class="row g-2">
          <div class="col-md-6">
            <input name="repo_url" class="form-control" placeholder="Repo URL (optional)" value="{{ $submission->repo_url ?? '' }}">
          </div>
          <div class="col-md-6">
            <input name="demo_url" class="form-control" placeholder="Demo URL (optional)" value="{{ $submission->demo_url ?? '' }}">
          </div>
        </div>

        <div class="row g-2 mt-1">
          <div class="col-md-8">
            <input name="pr_url" class="form-control" placeholder="PR URL (optional)" value="{{ $submission->pr_url ?? '' }}">
          </div>
          <div class="col-md-4">
            <input name="commit_hash" class="form-control" placeholder="Commit hash (optional)" value="{{ $submission->commit_hash ?? '' }}">
          </div>
        </div>

        <button class="btn btn-primary mt-2">Save Submission</button>
      </form>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body">
      <h4>Support Shortcuts</h4>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ url('/forum') }}" class="btn btn-outline-primary">Ask in Forum</a>
        <a href="{{ url('/chat') }}" class="btn btn-outline-primary">Open Chat Channel</a>
        <a href="{{ url('/learn') }}" class="btn btn-outline-primary">Book Mentorship</a>
      </div>
    </div>
  </div>
</div>
@endsection
