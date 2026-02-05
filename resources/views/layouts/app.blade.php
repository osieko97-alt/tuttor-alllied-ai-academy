<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard • Tutor & Allied')</title>
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
</body>
</html>
