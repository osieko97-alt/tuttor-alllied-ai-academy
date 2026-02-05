@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 820px;">
  <h1>Link Incubation Project</h1>
  <p class="text-muted">Choose a project you own or one you're a team member of.</p>

  @if(!isset($projects) || $projects->count() === 0)
    <div class="alert alert-warning">
      You don't have any eligible projects yet.
      <a href="{{ url('/incubation') }}" class="btn btn-outline-primary btn-sm ms-2">Submit a Project</a>
    </div>
  @else
    <form method="POST" action="{{ route('learn.project.link.store',$enrollment->id) }}">
      @csrf

      <div class="mb-3">
        <label for="project_id" class="form-label">Select Project</label>
        <select name="project_id" id="project_id" class="form-select" required>
          @foreach($projects as $p)
            <option value="{{ $p->id }}">{{ $p->title }} — {{ strtoupper($p->stage) }}</option>
          @endforeach
        </select>
      </div>

      <button class="btn btn-primary">Link Project</button>
    </form>
  @endif
</div>
@endsection
