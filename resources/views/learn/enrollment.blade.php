@extends('layouts.app')

@section('content')
<div class="container py-4">
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h1 class="mb-1">{{ $enrollment->track_name }} Sprint</h1>
      <div class="text-muted">Day {{ $enrollment->current_day }} of 14 • Started: {{ $enrollment->start_date }}</div>
      <p class="mt-2">{{ $enrollment->track_description }}</p>
    </div>
    <div class="text-end">
      <a class="btn btn-outline-primary" href="{{ route('deploy.index') }}">Deploy Checklist</a>
      <a class="btn btn-primary ms-2" href="{{ route('learn.day.show',[$enrollment->id,$enrollment->current_day]) }}">Continue Day {{ $enrollment->current_day }}</a>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div class="fw-bold">Progress</div>
        <div class="text-muted">{{ $daysDone }}/14 days completed</div>
      </div>
      <div class="progress mt-2" style="height:10px;">
        <div class="progress-bar" style="width: {{ ($daysDone/14)*100 }}%"></div>
      </div>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-bold">Linked Incubation Project</div>
          <div class="text-muted small">Required for graduation.</div>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('learn.project.link.show',$enrollment->id) }}">
          {{ $project ? 'Change Project' : 'Link Project' }}
        </a>
      </div>

      @if($project)
        <div class="mt-2">
          <div class="fw-bold">{{ $project->title }}</div>
          <div class="text-muted">{{ $project->pitch }}</div>
          <a href="{{ url('/incubation') }}" class="btn btn-sm btn-outline-secondary mt-2">Open Project</a>
        </div>
      @else
        <div class="alert alert-warning mt-2 mb-0">No project linked yet. Link one to graduate.</div>
      @endif
    </div>
  </div>

  <h3 class="mt-4">14-Day Plan</h3>
  <div class="list-group">
    @foreach($days as $d)
      @php $done = ($completionMap[$d->day_number]->is_completed ?? false); @endphp
      <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
         href="{{ route('learn.day.show',[$enrollment->id,$d->day_number]) }}">
        <div>
          <div class="fw-bold">Day {{ $d->day_number }} — {{ $d->focus }}</div>
          <div class="text-muted small">{{ $d->content }}</div>
        </div>
        <span class="badge {{ $done ? 'text-bg-success' : 'text-bg-warning' }}">
          {{ $done ? 'DONE' : 'PENDING' }}
        </span>
      </a>
    @endforeach
  </div>

  <div class="mt-4">
    <a class="btn btn-success" href="{{ route('graduation.index') }}">Check Graduation</a>
  </div>
</div>
@endsection
