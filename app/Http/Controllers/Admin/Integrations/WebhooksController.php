<?php

namespace App\Http\Controllers\Admin\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhooksController extends Controller
{
    public function index(string $key)
    {
        $logs = DB::table('webhook_logs')
            ->where('provider', $key)
            ->orderByDesc('created_at')
            ->paginate(50);

        $stats = [
            'total' => DB::table('webhook_logs')->where('provider', $key)->count(),
            'received' => DB::table('webhook_logs')->where('provider', $key)->where('status', 'received')->count(),
            'processed' => DB::table('webhook_logs')->where('provider', $key)->where('status', 'processed')->count(),
            'failed' => DB::table('webhook_logs')->where('provider', $key)->where('status', 'failed')->count(),
        ];

        return view('admin.integrations.webhooks', compact('key', 'logs', 'stats'));
    }

    public function rotateSecret(Request $request, string $key)
    {
        // Generate new webhook secret (store in integrations table)
        $newSecret = hash('sha256', Str::random(64));

        DB::table('integrations')->where('key', $key)->update([
            'webhook_secret' => $newSecret,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Webhook secret rotated. Update your provider settings.');
    }

    public function replay(Request $request, string $key, int $eventLogId)
    {
        $log = DB::table('webhook_logs')->where('id', $eventLogId)->first();

        if (!$log) {
            return back()->with('error', 'Event log not found.');
        }

        // Mark as replayed
        DB::table('webhook_logs')->where('id', $eventLogId)->update([
            'status' => 'replayed',
            'updated_at' => now(),
        ]);

        // In a real implementation, you would re-dispatch the webhook event here
        // For now, just log the replay action
        DB::table('webhook_replays')->insert([
            'original_log_id' => $eventLogId,
            'replayed_by_user_id' => $request->user()->id,
            'replayed_at' => now(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Webhook event marked for replay.');
    }
}
