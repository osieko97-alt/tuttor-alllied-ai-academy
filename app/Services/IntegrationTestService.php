<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IntegrationTestService
{
    private Client $http;

    public function __construct()
    {
        $this->http = new Client(['timeout' => 10]);
    }

    /**
     * Run a test for a specific integration.
     */
    public function test(string $integrationKey): array
    {
        $integration = DB::table('integrations')->where('key', $integrationKey)->first();

        if (!$integration) {
            return ['success' => false, 'error' => 'Integration not found.'];
        }

        if (!$integration->is_enabled) {
            return ['success' => false, 'error' => 'Integration is disabled.'];
        }

        $secret = $integration->secret_encrypted
            ? Crypt::decryptString($integration->secret_encrypted)
            : null;

        $settings = json_decode($integration->settings ?? '{}', true);

        $result = match ($integrationKey) {
            'github' => $this->testGitHub($secret),
            'google' => $this->testGoogle($secret),
            'sendgrid' => $this->testSendGrid($secret),
            'mailgun' => $this->testMailgun($settings['domain'] ?? null, $secret),
            'pusher' => $this->testPusher($settings['app_id'] ?? null, $settings['key'] ?? null, $secret),
            default => ['success' => false, 'error' => 'No test defined for this integration.'],
        };

        // Update integration with test result
        DB::table('integrations')->where('key', $integrationKey)->update([
            'last_tested_at' => now(),
            'last_test_status' => $result['success'] ? 'success' : 'failed',
            'last_test_error' => $result['error'] ?? null,
            'updated_at' => now(),
        ]);

        return $result;
    }

    private function testGitHub(?string $token): array
    {
        try {
            $response = $this->http->get('https://api.github.com/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/vnd.github+json',
                    'User-Agent' => 'Tutor-Allied.dev',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $user = json_decode($response->getBody(), true);
                return [
                    'success' => true,
                    'message' => 'Connected as @' . ($user['login'] ?? 'unknown'),
                    'details' => $user,
                ];
            }

            return ['success' => false, 'error' => 'GitHub API returned status: ' . $response->getStatusCode()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function testGoogle(?string $accessToken): array
    {
        try {
            $response = $this->http->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $user = json_decode($response->getBody(), true);
                return [
                    'success' => true,
                    'message' => 'Connected as ' . ($user['email'] ?? 'unknown'),
                    'details' => $user,
                ];
            }

            return ['success' => false, 'error' => 'Google API returned status: ' . $response->getStatusCode()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function testSendGrid(?string $apiKey): array
    {
        try {
            $response = $this->http->get('https://api.sendgrid.com/v3/user/profile', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $profile = json_decode($response->getBody(), true);
                return [
                    'success' => true,
                    'message' => 'SendGrid connected',
                    'details' => $profile,
                ];
            }

            return ['success' => false, 'error' => 'SendGrid API returned status: ' . $response->getStatusCode()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function testMailgun(?string $domain, ?string $apiKey): array
    {
        if (!$domain || !$apiKey) {
            return ['success' => false, 'error' => 'Missing domain or API key.'];
        }

        try {
            $response = $this->http->get("https://api.mailgun.net/v3/{$domain}/log", [
                'auth' => ['api', $apiKey],
            ]);

            if ($response->getStatusCode() === 200) {
                return [
                    'success' => true,
                    'message' => 'Mailgun connected',
                ];
            }

            return ['success' => false, 'error' => 'Mailgun API returned status: ' . $response->getStatusCode()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function testPusher(?string $appId, ?string $key, ?string $secret): array
    {
        if (!$appId || !$key || !$secret) {
            return ['success' => false, 'error' => 'Missing app_id, key, or secret.'];
        }

        try {
            // Pusher doesn't have a simple "test" endpoint, so we authenticate a test channel
            $auth = base64_encode("{$key}:{$secret}");
            $response = $this->http->post("https://api-pusherapp.com/apps/{$appId}/events", [
                'headers' => [
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => 'test',
                    'data' => json_encode(['test' => true]),
                    'channels' => ['test-channel'],
                ],
            ]);

            return [
                'success' => $response->getStatusCode() === 200,
                'message' => $response->getStatusCode() === 200 ? 'Pusher connected' : 'Pusher connection failed',
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
