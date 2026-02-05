<?php

namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use App\Models\TrackEnrollment;
use App\Services\Graduation\GraduationEligibility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GraduationController extends Controller
{
    public function index(Request $request, GraduationEligibility $eligibility)
    {
        $user = $request->user();

        $enrollment = TrackEnrollment::with(['track', 'linkedProject'])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->first();

        if (!$enrollment) {
            return redirect()->route('tracks.index')->with('error', 'Start a track to graduate.');
        }

        $result = $eligibility->check($enrollment);

        return view('graduation.index', [
            'enrollment' => $enrollment,
            'result' => $result,
        ]);
    }

    public function graduate(Request $request, $enrollmentId, GraduationEligibility $eligibility)
    {
        $user = $request->user();

        $enrollment = TrackEnrollment::with(['track', 'linkedProject'])
            ->where('id', $enrollmentId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $result = $eligibility->check($enrollment);

        if (!$result['eligible']) {
            return redirect()->route('graduation.index')
                ->with('error', 'Not eligible yet. Complete missing requirements.');
        }

        // Create certificate record if not exists
        $existing = DB::table('certificates')
            ->where('enrollment_id', $enrollment->id)
            ->first();

        if (!$existing) {
            DB::table('certificates')->insert([
                'enrollment_id' => $enrollment->id,
                'user_id' => $user->id,
                'track_id' => $enrollment->track_id,
                'project_id' => $enrollment->linked_project_id,
                'certificate_code' => strtoupper(Str::random(10)),
                'issued_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Mark enrollment as completed
        DB::table('track_enrollments')
            ->where('id', $enrollment->id)
            ->update([
                'status' => 'graduated',
                'updated_at' => now(),
            ]);

        return redirect()->route('certificate.show', $enrollment->id)
            ->with('success', 'Congratulations! You have graduated.');
    }

    public function certificate(Request $request, $enrollmentId)
    {
        $user = $request->user();

        $cert = DB::table('certificates')
            ->where('enrollment_id', $enrollmentId)
            ->where('user_id', $user->id)
            ->first();

        if (!$cert) {
            return redirect()->route('graduation.index')->with('error', 'No certificate found. Graduate first.');
        }

        $enrollment = TrackEnrollment::with(['track', 'linkedProject'])
            ->where('id', $enrollmentId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('graduation.certificate', [
            'cert' => $cert,
            'enrollment' => $enrollment,
        ]);
    }
}
