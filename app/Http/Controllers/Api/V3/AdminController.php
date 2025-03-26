<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function stats(Request $request)
    {
        // Total courses
        $total = Course::count();

        // By status
        $byStatus = Course::groupBy('status')
            ->select('status', DB::raw('count(*) as count'))
            ->get()
            ->map(function ($item) {
                return [
                    'status' => $item->status,
                    'count' => $item->count,
                ];
            });

        // By category
        $byCategory = Course::with('category')
            ->groupBy('category_id')
            ->select('category_id', DB::raw('count(*) as count'))
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'count' => $item->count,
                    'category' => [
                        'id' => $item->category->id,
                        'name' => $item->category->name,
                    ],
                ];
            });

        // Most enrolled (top 5)
        $mostEnrolled = Course::withCount('students') // Assuming 'students' relation from enrollments
            ->orderBy('students_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'status' => $course->status,
                    'category_id' => $course->category_id,
                    'created_at' => $course->created_at->toISOString(),
                    'updated_at' => $course->updated_at->toISOString(),
                    'price' => $course->price ?? 0, // Adjust if nullable
                    'currency' => 'USD', // Hardcoded, adjust if dynamic
                    'is_free' => $course->price == 0 ? 1 : 0,
                    'enrollments_count' => $course->students_count,
                ];
            });

        // Recent courses (last 5)
        $recent = Course::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'created_at' => $course->created_at->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'by_status' => $byStatus,
                'by_category' => $byCategory,
                'most_enrolled' => $mostEnrolled,
                'recent' => $recent,
            ],
        ]);
    }
}