<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LearnHubController extends Controller
{
  public function index(Request $request)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->join('tracks','tracks.id','=','track_enrollments.track_id')
      ->where('track_enrollments.user_id',$userId)
      ->where('track_enrollments.status','active')
      ->select('track_enrollments.*','tracks.name as track_name','tracks.slug as track_slug')
      ->orderByDesc('track_enrollments.id')
      ->first();

    if (!$enrollment) {
      // show available tracks list
      $tracks = DB::table('tracks')->orderBy('id')->get();
      return view('learn.index', compact('enrollment','tracks'));
    }

    return redirect()->route('learn.enrollment.show', $enrollment->id);
  }

  public function show(Request $request, int $enrollmentId)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->join('tracks','tracks.id','=','track_enrollments.track_id')
      ->where('track_enrollments.id',$enrollmentId)
      ->where('track_enrollments.user_id',$userId)
      ->select('track_enrollments.*','tracks.name as track_name','tracks.slug as track_slug','tracks.description as track_description')
      ->first();

    abort_unless($enrollment, 404);

    $days = DB::table('lessons')
      ->where('track_id',$enrollment->track_id)
      ->orderBy('day_number')
      ->get();

    $completionMap = DB::table('track_day_completions')
      ->where('enrollment_id',$enrollmentId)
      ->get()
      ->keyBy('day_number');

    $daysDone = $completionMap->where('is_completed', true)->count();

    $project = null;
    if ($enrollment->project_id) {
      $project = DB::table('projects')->where('id',$enrollment->project_id)->first();
    }

    return view('learn.enrollment', compact('enrollment','days','completionMap','daysDone','project'));
  }
}
