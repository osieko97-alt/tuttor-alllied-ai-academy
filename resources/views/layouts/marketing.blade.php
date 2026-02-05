<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Tutor & Allied AI Academy - Deploy a real project in 14 days. Learn to code, build in public, get reviewed, and launch your career.">
  <title>@yield('title', 'Tutor & Allied AI Academy')</title>
  <link rel="stylesheet" href="/assets/css/theme.css">
</head>
<body class="page-wrapper">
  <!-- Navigation -->
  <x-nav.top />

  <!-- Main Content -->
  <main class="main-content">
    <div class="container">
      <x-flash />

      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="container" style="padding-top: var(--space-8); padding-bottom: var(--space-8);">
    <div class="card" style="display: flex; gap: var(--space-6); flex-wrap: wrap; justify-content: space-between; align-items: center;">
      <div>
        <strong style="font-size: var(--text-lg);">Tutor & Allied AI Academy</strong>
        <div class="text-muted" style="margin-top: var(--space-1);">Deploy in 14 days. Build in public.</div>
      </div>

      <div style="display: flex; gap: var(--space-6); flex-wrap: wrap;">
        <a href="/tracks">Tracks</a>
        <a href="/courses">Courses</a>
        <a href="/incubation">Incubation</a>
        <a href="/partners">Partners</a>
        <a href="/forum">Forum</a>
        <a href="/blog">Blog</a>
        <a href="/ai">AI</a>
      </div>

      <div style="display: flex; gap: var(--space-4); flex-wrap: wrap; border-top: 1px solid var(--border); padding-top: var(--space-4); margin-top: var(--space-4); width: 100%;">
        <div style="font-size: var(--text-sm);">
          &copy; {{ date('Y') }} Tutor & Allied. All rights reserved.
        </div>
        <div style="display: flex; gap: var(--space-4); margin-left: auto;">
          <a href="/terms">Terms</a>
          <a href="/privacy">Privacy</a>
          <a href="/code-of-conduct">Code of Conduct</a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
