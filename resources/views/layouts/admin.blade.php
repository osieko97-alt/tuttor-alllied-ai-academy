<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin • Tutor & Allied')</title>
  <link rel="stylesheet" href="/assets/css/theme.css">
</head>
<body class="page-wrapper">
  <div class="container" style="display: grid; grid-template-columns: var(--sidebar-width) 1fr; gap: var(--space-6); padding-top: var(--space-6);">

    <!-- Sidebar -->
    <aside class="card" style="position: sticky; top: var(--space-6); height: fit-content;">
      <div style="padding: var(--space-3); margin-bottom: var(--space-4); border-bottom: 1px solid var(--border);">
        <strong style="font-size: var(--text-lg);">Admin Panel</strong>
        <div class="text-muted" style="font-size: var(--text-sm);">Tutor & Allied</div>
      </div>

      <x-nav.admin-sidebar />

      <div style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="/" class="btn btn-secondary btn-sm" style="width: 100%;">
          &larr; Back to Site
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main>
      <x-flash />

      @yield('content')
    </main>
  </div>
</body>
</html>
