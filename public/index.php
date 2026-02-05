<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/');
$path = $path === '' ? '/' : $path;

$routes = [
    '/' => 'home',
    '/tracks' => 'tracks',
    '/courses' => 'courses',
    '/incubation' => 'incubation',
    '/partners' => 'partners',
    '/forum' => 'forum',
    '/blog' => 'blog',
    '/ai' => 'ai',
    '/legal/terms' => 'legal/terms',
    '/legal/privacy' => 'legal/privacy',
    '/legal/code-of-conduct' => 'legal/code-of-conduct',
    '/contact' => 'contact',
];

$template = $routes[$path] ?? 'not-found';
http_response_code($template === 'not-found' ? 404 : 200);

require __DIR__ . '/../resources/views/partials/layout-start.php';
require __DIR__ . '/../resources/views/partials/nav.php';
require __DIR__ . '/../resources/views/pages/' . $template . '.php';
require __DIR__ . '/../resources/views/partials/footer.php';
require __DIR__ . '/../resources/views/partials/layout-end.php';
