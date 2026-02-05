<?php

namespace App\Http\Controllers\Admin\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class IntegrationsController extends Controller
{
    public function index()
    {
        $integrations = DB::table('integrations')
            ->orderBy('name')
            ->get();

        return view('admin.integrations.index', compact('integrations'));
    }

    public function edit(string $key)
    {
        $integration = DB::table('integrations')->where('key', $key)->first();

        if (!$integration) {
            return back()->with('error', 'Integration not found.');
        }

        // Decrypt secret if exists
        $secret = $integration->secret_encrypted
            ? Crypt::decryptString($integration->secret_encrypted)
            : '';

        $integration->secret_plain = $secret;
        $integration->settings_decoded = json_decode($integration->settings ?? '{}', true);

        return view('admin.integrations.edit', compact('integration'));
    }

    public function update(Request $request, string $key)
    {
        $request->validate([
            'is_enabled' => 'nullable|boolean',
            'settings' => 'nullable|array',
            'secret' => 'nullable|string',
        ]);

        $data = [
            'is_enabled' => $request->boolean('is_enabled'),
            'settings' => json_encode($request->input('settings', [])),
            'updated_at' => now(),
        ];

        if ($request->filled('secret')) {
            $data['secret_encrypted'] = Crypt::encryptString($request->secret);
        }

        DB::table('integrations')->where('key', $key)->update($data);

        return redirect()->route('admin.integrations.index')
            ->with('success', 'Integration updated.');
    }

    public function enable(string $key)
    {
        DB::table('integrations')->where('key', $key)->update([
            'is_enabled' => true,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Integration enabled.');
    }

    public function disable(string $key)
    {
        DB::table('integrations')->where('key', $key)->update([
            'is_enabled' => false,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Integration disabled.');
    }

    public function rotateSecrets(Request $request, string $key)
    {
        // This would typically generate new credentials and notify admin
        // For now, just clear the secret and require manual re-entry
        DB::table('integrations')->where('key', $key)->update([
            'secret_encrypted' => null,
            'is_enabled' => false,
            'updated_at' => now(),
        ]);

        return back()->with('info', 'Secret rotated. Please re-enter new credentials.');
    }
}
