<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeployChecklistSeeder extends Seeder
{
  public function run(): void
  {
    $tplId = DB::table('deploy_checklist_templates')->insertGetId([
      'name' => 'Web App MVP (Default)',
      'slug' => 'web-app-mvp-default',
      'audience' => 'developers',
      'description' => 'Minimum standards for a real deployed MVP.',
      'is_active' => true,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $items = [
      ['General','MVP scope is defined (what it does & does not do)', null, 1, false, false, true],
      ['Code','GitHub repo exists and is public or shareable', 'Add a README and commit history.', 2, true, false, true],
      ['Code','App runs locally without errors', 'Document setup steps.', 3, false, false, true],
      ['Code','Input validation is implemented', 'Prevent crashes on empty/invalid input.', 4, false, false, true],
      ['Docs','README includes setup + usage + screenshots', 'Short and clear is fine.', 5, true, false, true],
      ['Deploy','App is deployed and accessible via a link', 'Use shared hosting/VPS/Render/etc.', 6, false, true, true],
      ['Deploy','Basic smoke test passed on live site', 'Test at least 5 real user flows.', 7, false, true, true],
      ['Community','Project listed in Incubation Chambers', 'Your project must be reviewable.', 8, true, false, true],
      ['Community','At least 1 GitHub-based review submitted', 'PR link or commit hash proof.', 9, false, false, true],
    ];

    foreach ($items as $i => $row) {
      [$group,$title,$help,$sort,$reqRepo,$reqDemo,$required] = $row;

      DB::table('deploy_checklist_items')->insert([
        'template_id' => $tplId,
        'group' => $group,
        'title' => $title,
        'help_text' => $help,
        'sort_order' => $sort,
        'requires_repo' => $reqRepo,
        'requires_demo' => $reqDemo,
        'is_required' => $required,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
