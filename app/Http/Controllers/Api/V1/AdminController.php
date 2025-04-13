<?php
// app/Http/Controllers/Api/V1/AdminController.php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function courseStats()
    {
        $total = Course::count();

        $byStatus = Course::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => $item->status,
                    'count' => $item->count,
                ];
            });

        $byCategory = Course::groupBy('category_id')
            ->selectRaw('category_id, count(*) as count')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'count' => $item->count,
                    'category' => $item->category ? [
                        'id' => $item->category->id,
                        'name' => $item->category->name,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'by_status' => $byStatus,
                'by_category' => $byCategory,
            ],
        ]);
    }

    public function categoryStats()
    {
        $total = Category::count();
        $withCourses = Category::withCount('courses')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'details' => $withCourses,
            ],
        ]);
    }

    public function tagStats()
    {
        $total = Tag::count();
        $withCourses = Tag::withCount('courses')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'details' => $withCourses,
            ],
        ]);
    }

    public function stats(Request $request)
    {
        $total = Course::count();

        $byStatus = Course::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => $item->status,
                    'count' => $item->count,
                ];
            });

        $byCategory = Course::groupBy('category_id')
            ->selectRaw('category_id, count(*) as count')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'count' => $item->count,
                    'category' => $item->category ? [
                        'id' => $item->category->id,
                        'name' => $item->category->name,
                    ] : null,
                ];
            });

        $mostEnrolled = Course::withCount('students')
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
                    'price' => $course->price ?? 0,
                    'currency' => 'USD',
                    'is_free' => $course->isFree(),
                    'enrollments_count' => $course->students_count,
                ];
            });

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