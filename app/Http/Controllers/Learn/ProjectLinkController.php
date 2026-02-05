<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectLinkController extends Controller
{
  public function show(Request $request, int $enrollmentId)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->where('id',$enrollmentId)
      ->where('user_id',$userId)
      ->first();
    abort_unless($enrollment, 404);

    // Let them pick projects they own OR any public
    $owned = DB::table('projects')->where('user_id',$userId)->where('status','active')->latest()->get();

    $teamProjectIds = DB::table('project_team_members')->where('user_id',$userId)->pluck('project_id');
    $team = DB::table('projects')->whereIn('id',$teamProjectIds)->where('status','active')->latest()->get();

    // Merge unique
    $projects = $owned->merge($team)->unique('id')->values();

    return view('learn.link-project', compact('enrollment','projects'));
  }

  public function store(Request $request, int $enrollmentId)
  {
    $userId = $request->user()->id;

    $enrollment = DB::table('track_enrollments')
      ->where('id',$enrollmentId)
      ->where('user_id',$userId)
      ->first();
    abort_unless($enrollment, 404);

    $data = $request->validate([
      'project_id' => ['required','integer'],
    ]);

    // validate project belongs to user or user is team member
    $isOwner = DB::table('projects')->where('id',$data['project_id'])->where('user_id',$userId)->exists();
    $isMember = DB::table('project_team_members')->where('project_id',$data['project_id'])->where('user_id',$userId)->exists();

    abort_unless($isOwner || $isMember, 403);

    DB::table('track_enrollments')->where('id',$enrollmentId)->update([
      'project_id' => $data['project_id'],
      'updated_at' => now(),
    ]);

    return redirect()->route('learn.enrollment.show',$enrollmentId)->with('success','Project linked to your sprint.');
  }
}
