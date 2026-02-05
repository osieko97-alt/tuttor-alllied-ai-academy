<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
{
  public function show(Request $request, int $enrollmentId, int $day)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->join('tracks','tracks.id','=','track_enrollments.track_id')
      ->where('track_enrollments.id',$enrollmentId)
      ->where('track_enrollments.user_id',$userId)
      ->select('track_enrollments.*','tracks.name as track_name')
      ->first();

    abort_unless($enrollment, 404);
    abort_if($day < 1 || $day > 14, 404);

    $trackDay = DB::table('lessons')
      ->where('track_id',$enrollment->track_id)
      ->where('day_number',$day)
      ->first();

    $completion = DB::table('track_day_completions')
      ->where('enrollment_id',$enrollmentId)
      ->where('day_number',$day)
      ->first();

    // initialize if missing (safety)
    if (!$completion) {
      $tasks = [$trackDay->focus ?? 'Complete lesson'];
      $tasksState = array_map(fn($t)=>['text'=>$t,'done'=>false], $tasks);
      DB::table('track_day_completions')->insert([
        'enrollment_id'=>$enrollmentId,
        'day_number'=>$day,
        'tasks_state'=>json_encode($tasksState),
        'is_completed'=>false,
        'created_at'=>now(),
        'updated_at'=>now(),
      ]);
      $completion = DB::table('track_day_completions')
        ->where('enrollment_id',$enrollmentId)->where('day_number',$day)->first();
    }

    $tasksState = json_decode($completion->tasks_state ?? '[]', true) ?: [];

    $submission = DB::table('track_day_submissions')
      ->where('enrollment_id',$enrollmentId)
      ->where('day_number',$day)
      ->orderByDesc('id')
      ->first();

    return view('learn.day', compact('enrollment','day','trackDay','completion','tasksState','submission'));
  }

  public function submit(Request $request, int $enrollmentId, int $day)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->where('id',$enrollmentId)
      ->where('user_id',$userId)
      ->first();

    abort_unless($enrollment, 404);
    abort_if($day < 1 || $day > 14, 404);

    $data = $request->validate([
      'notes' => ['nullable','string','max:2000'],
      'repo_url' => ['nullable','url','max:255'],
      'demo_url' => ['nullable','url','max:255'],
      'pr_url' => ['nullable','url','max:255'],
      'commit_hash' => ['nullable','string','max:80'],
    ]);

    DB::table('track_day_submissions')->insert([
      'enrollment_id'=>$enrollmentId,
      'day_number'=>$day,
      'notes'=>$data['notes'] ?? null,
      'repo_url'=>$data['repo_url'] ?? null,
      'demo_url'=>$data['demo_url'] ?? null,
      'pr_url'=>$data['pr_url'] ?? null,
      'commit_hash'=>$data['commit_hash'] ?? null,
      'created_at'=>now(),
      'updated_at'=>now(),
    ]);

    return back()->with('success','Submission saved.');
  }
}
