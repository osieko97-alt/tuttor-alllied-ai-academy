<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollController extends Controller
{
  public function store(Request $request, Track $track)
  {
    $user = $request->user();

    DB::transaction(function () use ($user, $track) {

      $enrollment = DB::table('track_enrollments')->updateOrInsert(
        ['user_id' => $user->id, 'track_id' => $track->id],
        [
          'start_date' => now()->toDateString(),
          'target_end_date' => now()->addDays(13)->toDateString(),
          'current_day' => 1,
          'status' => 'active',
          'updated_at' => now(),
          'created_at' => now(),
        ]
      );

      $enrollmentId = DB::table('track_enrollments')
        ->where('user_id',$user->id)->where('track_id',$track->id)->value('id');

      // Create 14 day completion rows (tasks copied from lessons table)
      $days = DB::table('lessons')->where('track_id',$track->id)->orderBy('day_number')->get();

      foreach ($days as $d) {
        // Create tasks from the focus and content fields
        $tasks = [
          'Complete: ' . $d->focus,
          $d->content,
        ];
        $tasksState = array_map(fn($t) => ['text'=>$t,'done'=>false], $tasks);

        DB::table('track_day_completions')->updateOrInsert(
          ['enrollment_id'=>$enrollmentId, 'day_number'=>$d->day_number],
          [
            'tasks_state' => json_encode($tasksState),
            'is_completed' => false,
            'completed_at' => null,
            'updated_at' => now(),
            'created_at' => now(),
          ]
        );
      }

      // Create deploy checklist instance (use default active template)
      $templateId = DB::table('deploy_checklist_templates')->where('is_active',true)->orderBy('id')->value('id');

      DB::table('user_deploy_checklists')->updateOrInsert(
        ['user_id'=>$user->id,'enrollment_id'=>$enrollmentId],
        [
          'template_id'=>$templateId,
          'status'=>'in_progress',
          'deploy_ready_at'=>null,
          'completed_at'=>null,
          'updated_at'=>now(),
          'created_at'=>now(),
        ]
      );

      $userChecklistId = DB::table('user_deploy_checklists')
        ->where('user_id',$user->id)->where('enrollment_id',$enrollmentId)->value('id');

      // Create item state rows
      $items = DB::table('deploy_checklist_items')->where('template_id',$templateId)->orderBy('sort_order')->get();
      foreach ($items as $it) {
        DB::table('user_deploy_checklist_items')->updateOrInsert(
          ['user_checklist_id'=>$userChecklistId,'item_id'=>$it->id],
          [
            'is_done'=>false,
            'done_at'=>null,
            'repo_url'=>null,
            'demo_url'=>null,
            'notes'=>null,
            'updated_at'=>now(),
            'created_at'=>now(),
          ]
        );
      }

    });

    return redirect('/dashboard')->with('success','Enrolled! Your 14-day sprint is ready.');
  }
}
