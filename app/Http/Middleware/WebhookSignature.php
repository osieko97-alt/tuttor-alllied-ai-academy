<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip signature verification in local development
        if (app()->environment('local')) {
            return $next($request);
        }

        $provider = $request->route('provider');
        $secret = config("webhooks.{$provider}.secret");

        if (!$secret) {
            logger()->warning("No webhook secret configured for provider: {$provider}");
            return $next($request);
        }

        $signature = $request->header('X-Hub-Signature-256') ?? $request->header('X-Hub-Signature');
        $body = $request->getContent();

        if (!$signature) {
            logger()->warning("Missing webhook signature for provider: {$provider}");
            abort(401, 'Missing signature');
        }

        $expected = 'sha256=' . hash_hmac('sha256', $body, $secret);
        $expected = 'sha1=' . hash_hmac('sha1', $body, $secret);

        if (!hash_equals($expected, $signature)) {
            logger()->warning("Invalid webhook signature for provider: {$provider}");
            abort(401, 'Invalid signature');
        }

        return $next($request);
    }
}
