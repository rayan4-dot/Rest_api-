<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $badgeId = $request->query('badges');
        $students = User::select('id', 'name')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'mentor');
            })
            ->when($badgeId, function ($q) use ($badgeId) {
                $q->whereHas('badges', function ($q) use ($badgeId) {
                    $q->where('badges.id', $badgeId);
                });
            })
            ->with(['badges' => function ($q) {
                $q->select('badges.id', 'badges.name', 'badges.description');
            }])
            ->get();

        return response()->json($students);
    }

    public function courses($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->user()->id !== $user->id && !$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $courses = $user->courses()->with('category')->get();
        return response()->json($courses);
    }

    public function progress($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->user()->id !== $user->id && !$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $progress = $user->courses()
            ->withPivot('progress_status')
            ->get()
            ->map(function ($course) {
                return [
                    'course_id' => $course->id,
                    'title' => $course->title,
                    'progress_status' => $course->pivot->progress_status,
                ];
            });

        return response()->json($progress);
    }

    public function badges($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->user()->id !== $user->id && !$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $badges = $user->badges;
        return response()->json($badges);
    }
}