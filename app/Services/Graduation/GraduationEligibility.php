<?php

namespace App\Services\Graduation;

use App\Models\TrackEnrollment;
use Illuminate\Support\Facades\DB;

class GraduationEligibility
{
    /**
     * Check if an enrollment is eligible for graduation.
     *
     * Requirements:
     * 1. All 14 days completed
     * 2. Deploy checklist complete
     * 3. Linked incubation project exists
     * 4. At least 1 verified review on linked project
     */
    public function check(TrackEnrollment $enrollment): array
    {
        $missing = [];

        // 1) All 14 days completed
        $daysCompleted = $enrollment->completions()
            ->distinct('day_number')
            ->count('day_number');

        if ($daysCompleted < 14) {
            $missing[] = [
                'key' => 'days',
                'label' => 'Complete all 14 days',
                'detail' => "$daysCompleted / 14 completed",
                'action_url' => route('learn.enrollment.show', $enrollment->id),
            ];
        }

        // 2) Deploy checklist complete
        $deployTotal = DB::table('user_deploy_checklist_items')
            ->where('user_id', $enrollment->user_id)
            ->count();

        $deployDone = DB::table('user_deploy_checklist_items')
            ->where('user_id', $enrollment->user_id)
            ->where('is_done', 1)
            ->count();

        if ($deployTotal === 0) {
            $missing[] = [
                'key' => 'deploy_init',
                'label' => 'Initialize deploy checklist',
                'detail' => 'No checklist items found for your account.',
                'action_url' => route('deploy.index'),
            ];
        } elseif ($deployDone < $deployTotal) {
            $missing[] = [
                'key' => 'deploy',
                'label' => 'Complete deploy checklist',
                'detail' => "$deployDone / $deployTotal completed",
                'action_url' => route('deploy.index'),
            ];
        }

        // 3) Linked incubation project
        if (!$enrollment->linked_project_id) {
            $missing[] = [
                'key' => 'project',
                'label' => 'Link an incubation project',
                'detail' => 'No project linked to this enrollment.',
                'action_url' => route('learn.linkproject.show', $enrollment->id),
            ];
        } else {
            // 4) At least 1 verified review on that project
            $verifiedReviews = DB::table('project_reviews')
                ->where('project_id', $enrollment->linked_project_id)
                ->where('status', 'verified')
                ->count();

            if ($verifiedReviews < 1) {
                $project = DB::table('projects')->where('id', $enrollment->linked_project_id)->first();

                $missing[] = [
                    'key' => 'review',
                    'label' => 'Get at least 1 verified review',
                    'detail' => 'No verified review found yet.',
                    'action_url' => $project ? route('incubation.show', $project->slug) : route('incubation.index'),
                ];
            }
        }

        return [
            'eligible' => count($missing) === 0,
            'missing' => $missing,
            'summary' => [
                'days_completed' => $daysCompleted,
                'deploy_done' => $deployDone,
                'deploy_total' => $deployTotal,
            ],
        ];
    }
}
