<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
  public function updateDayTasks(Request $request, int $enrollmentId, int $day)
  {
    $userId = $request->user()->id;

    $row = DB::table('track_day_completions')
      ->join('track_enrollments','track_enrollments.id','=','track_day_completions.enrollment_id')
      ->where('track_enrollments.user_id',$userId)
      ->where('track_day_completions.enrollment_id',$enrollmentId)
      ->where('track_day_completions.day_number',$day)
      ->select('track_day_completions.*')
      ->first();

    abort_unless($row, 404);

    // Expect payload: tasks_state[] = {text, done}
    $data = $request->validate([
      'tasks_state' => ['required','array'],
      'tasks_state.*.text' => ['required','string'],
      'tasks_state.*.done' => ['required','boolean'],
    ]);

    $allDone = collect($data['tasks_state'])->every(fn($t) => (bool)$t['done'] === true);

    DB::table('track_day_completions')
      ->where('id',$row->id)
      ->update([
        'tasks_state' => json_encode($data['tasks_state']),
        'is_completed' => $allDone,
        'completed_at' => $allDone ? now() : null,
        'updated_at' => now(),
      ]);

    // If day completed, advance current_day (up to 14)
    if ($allDone) {
      $currentDay = DB::table('track_enrollments')->where('id',$enrollmentId)->value('current_day');
      if ((int)$currentDay === (int)$day && $day < 14) {
        DB::table('track_enrollments')->where('id',$enrollmentId)->update([
          'current_day' => $day + 1,
          'updated_at' => now(),
        ]);
      }
    }

    return back()->with('success','Progress saved.');
  }
}
