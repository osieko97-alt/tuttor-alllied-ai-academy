<?php

namespace App\Http\Controllers\Deploy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeployChecklistController extends Controller
{
  public function index(Request $request)
  {
    $userId = $request->user()->id;

    // Active enrollment (latest active)
    $enrollment = DB::table('track_enrollments')
      ->join('tracks','tracks.id','=','track_enrollments.track_id')
      ->where('track_enrollments.user_id',$userId)
      ->where('track_enrollments.status','active')
      ->select('track_enrollments.*','tracks.name as track_name','tracks.slug as track_slug')
      ->orderByDesc('track_enrollments.id')
      ->first();

    if (!$enrollment) {
      return view('deploy.index', ['enrollment'=>null,'groups'=>[],'status'=>null]);
    }

    $checklist = DB::table('user_deploy_checklists')
      ->where('user_id',$userId)->where('enrollment_id',$enrollment->id)->first();

    if (!$checklist) {
      return view('deploy.index', ['enrollment'=>$enrollment,'groups'=>[],'status'=>'in_progress']);
    }

    $rows = DB::table('user_deploy_checklist_items')
      ->join('deploy_checklist_items','deploy_checklist_items.id','=','user_deploy_checklist_items.item_id')
      ->where('user_deploy_checklist_items.user_checklist_id',$checklist->id)
      ->select([
        'user_deploy_checklist_items.*',
        'deploy_checklist_items.group',
        'deploy_checklist_items.title',
        'deploy_checklist_items.help_text',
        'deploy_checklist_items.requires_repo',
        'deploy_checklist_items.requires_demo',
        'deploy_checklist_items.is_required',
        'deploy_checklist_items.sort_order',
      ])
      ->orderBy('deploy_checklist_items.group')
      ->orderBy('deploy_checklist_items.sort_order')
      ->get();

    $groups = $rows->groupBy('group');

    return view('deploy.index', [
      'enrollment'=>$enrollment,
      'groups'=>$groups,
      'status'=>$checklist->status,
    ]);
  }

  public function toggle(Request $request, int $userItemId)
  {
    $userId = $request->user()->id;

    $item = DB::table('user_deploy_checklist_items')
      ->join('user_deploy_checklists','user_deploy_checklists.id','=','user_deploy_checklist_items.user_checklist_id')
      ->join('deploy_checklist_items','deploy_checklist_items.id','=','user_deploy_checklist_items.item_id')
      ->where('user_deploy_checklist_items.id',$userItemId)
      ->where('user_deploy_checklists.user_id',$userId)
      ->select([
        'user_deploy_checklist_items.*',
        'user_deploy_checklists.id as checklist_id',
        'user_deploy_checklists.enrollment_id',
        'deploy_checklist_items.requires_repo',
        'deploy_checklist_items.requires_demo',
        'deploy_checklist_items.is_required',
      ])
      ->first();

    abort_unless($item, 404);

    $data = $request->validate([
      'repo_url' => ['nullable','url','max:255'],
      'demo_url' => ['nullable','url','max:255'],
      'notes' => ['nullable','string','max:2000'],
    ]);

    $newDone = !$item->is_done;

    // Enforce evidence if marking done
    if ($newDone) {
      if ($item->requires_repo && empty($data['repo_url']) && empty($item->repo_url)) {
        return back()->with('error','This item requires a repo URL.');
      }
      if ($item->requires_demo && empty($data['demo_url']) && empty($item->demo_url)) {
        return back()->with('error','This item requires a demo URL.');
      }
    }

    DB::table('user_deploy_checklist_items')->where('id',$userItemId)->update([
      'is_done' => $newDone,
      'done_at' => $newDone ? now() : null,
      'repo_url' => $data['repo_url'] ?? $item->repo_url,
      'demo_url' => $data['demo_url'] ?? $item->demo_url,
      'notes' => $data['notes'] ?? $item->notes,
      'updated_at' => now(),
    ]);

    // Re-evaluate checklist status: deploy_ready if all REQUIRED items done
    $requiredTotal = DB::table('user_deploy_checklist_items')
      ->join('deploy_checklist_items','deploy_checklist_items.id','=','user_deploy_checklist_items.item_id')
      ->where('user_deploy_checklist_items.user_checklist_id',$item->checklist_id)
      ->where('deploy_checklist_items.is_required', true)
      ->count();

    $requiredDone = DB::table('user_deploy_checklist_items')
      ->join('deploy_checklist_items','deploy_checklist_items.id','=','user_deploy_checklist_items.item_id')
      ->where('user_deploy_checklist_items.user_checklist_id',$item->checklist_id)
      ->where('deploy_checklist_items.is_required', true)
      ->where('user_deploy_checklist_items.is_done', true)
      ->count();

    if ($requiredTotal > 0 && $requiredDone === $requiredTotal) {
      DB::table('user_deploy_checklists')->where('id',$item->checklist_id)->update([
        'status' => 'deploy_ready',
        'deploy_ready_at' => now(),
        'updated_at' => now(),
      ]);
    } else {
      DB::table('user_deploy_checklists')->where('id',$item->checklist_id)->update([
        'status' => 'in_progress',
        'deploy_ready_at' => null,
        'updated_at' => now(),
      ]);
    }

    return back()->with('success','Checklist updated.');
  }
}
