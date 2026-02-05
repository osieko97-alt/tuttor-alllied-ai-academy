@if(session('success'))
    <div class="alert alert-success">
        <strong>Success!</strong>
        <div style="margin-top: var(--space-1);">{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong>
        <div style="margin-top: var(--space-1);">{{ session('error') }}</div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        <strong>Warning!</strong>
        <div style="margin-top: var(--space-1);">{{ session('warning') }}</div>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info">
        <strong>Info!</strong>
        <div style="margin-top: var(--space-1);">{{ session('info') }}</div>
    </div>
@endif
