<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $type = $request->get('type');

        $query = DB::table('reports')
            ->leftJoin('users as reporters', 'reports.reporter_id', '=', 'reporters.id')
            ->leftJoin('users as moderators', 'reports.moderator_id', '=', 'moderators.id')
            ->select([
                'reports.*',
                'reporters.name as reporter_name',
                'moderators.name as moderator_name',
            ])
            ->where('reports.status', $status);

        if ($type) {
            $query->where('reports.report_type', $type);
        }

        $reports = $query->orderByDesc('reports.created_at')->paginate(20);

        // Stats
        $stats = [
            'pending' => DB::table('reports')->where('status', 'pending')->count(),
            'reviewed' => DB::table('reports')->where('status', 'reviewed')->count(),
            'resolved' => DB::table('reports')->where('status', 'resolved')->count(),
            'dismissed' => DB::table('reports')->where('status', 'dismissed')->count(),
        ];

        return view('admin.moderation.index', compact('reports', 'stats', 'status', 'type'));
    }

    public function act(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'action' => 'required|in:resolve, dismiss, warn, suspend, ban',
            'notes' => 'nullable|string|max:1000',
        ]);

        $report = DB::table('reports')->where('id', $request->report_id)->first();

        if (!$report) {
            return back()->with('error', 'Report not found.');
        }

        $userId = $request->user()->id;

        // Update report status
        $status = $request->action === 'dismiss' ? 'dismissed' : 'resolved';
        DB::table('reports')
            ->where('id', $request->report_id)
            ->update([
                'status' => $status,
                'moderator_id' => $userId,
                'moderator_notes' => $request->notes,
                'reviewed_at' => now(),
                'updated_at' => now(),
            ]);

        // Log moderation action
        DB::table('moderation_logs')->insert([
            'report_id' => $request->report_id,
            'moderator_id' => $userId,
            'action' => $request->action,
            'notes' => $request->notes,
            'created_at' => now(),
        ]);

        // Execute action on user if needed
        if (in_array($request->action, ['warn', 'suspend', 'ban'])) {
            // Get reported user from reportable
            $reportedUserId = $this->getReportedUserId($report);
            if ($reportedUserId) {
                $action = $request->action; // warn, suspend, ban
                DB::table('user_actions')->insert([
                    'user_id' => $reportedUserId,
                    'action_type' => $action,
                    'moderator_id' => $userId,
                    'reason' => $request->notes,
                    'expires_at' => $action === 'suspend' ? now()->addDays(7) : null,
                    'created_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Report ' . ($status === 'dismissed' ? 'dismissed' : 'resolved') . '.');
    }

    private function getReportedUserId($report): ?int
    {
        // Determine reported user based on reportable_type
        // This is a simplified version - extend based on your models
        return match ($report->reportable_type) {
            'forum_post' => DB::table('forum_posts')->where('id', $report->reportable_id)->value('user_id'),
            'forum_thread' => DB::table('forum_threads')->where('id', $report->reportable_id)->value('user_id'),
            'chat_message' => DB::table('chat_messages')->where('id', $report->reportable_id)->value('user_id'),
            'project' => DB::table('projects')->where('id', $report->reportable_id)->value('owner_user_id'),
            default => null,
        };
    }
}
