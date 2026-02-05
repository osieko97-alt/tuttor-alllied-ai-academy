<nav class="container" style="padding-top: var(--space-4); padding-bottom: var(--space-4);">
  <div class="card" style="display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); flex-wrap: wrap;">
    <!-- Logo -->
    <div style="display: flex; align-items: center; gap: var(--space-3);">
      <a href="/" style="font-weight: 800; font-size: var(--text-xl); color: var(--text);">
        Tutor & Allied
      </a>
      <span class="badge badge-primary">AI Academy</span>
    </div>

    <!-- Main Navigation -->
    <div style="display: flex; align-items: center; gap: var(--space-1); flex-wrap: wrap;">
      <a href="/tracks" class="nav-link">Tracks</a>
      <a href="/courses" class="nav-link">Courses</a>
      <a href="/incubation" class="nav-link">Incubation</a>
      <a href="/partners" class="nav-link">Partners</a>
      <a href="/forum" class="nav-link">Forum</a>
      <a href="/blog" class="nav-link">Blog</a>
      <a href="/ai" class="badge">AI (Soon)</a>
    </div>

    <!-- Auth Navigation -->
    <div style="display: flex; align-items: center; gap: var(--space-3);">
      @auth
        <a href="/app" class="btn btn-primary btn-sm">
          Dashboard
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-ghost btn-sm">
            Logout
          </button>
        </form>
      @else
        <a href="/login" class="btn btn-ghost btn-sm">Login</a>
        <a href="/register" class="btn btn-primary btn-sm">Get Started</a>
      @endauth
    </div>
  </div>
</nav>
