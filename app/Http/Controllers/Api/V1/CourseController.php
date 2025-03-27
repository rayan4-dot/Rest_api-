<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category');

        return response()->json($this->courseService->getAllCourses($search, $categoryId));
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['mentor_id'] = auth()->id();  
        $course = $this->courseService->createCourse($data);
        return response()->json($course, 201);
    }

    public function show($id)
    {
        return response()->json($this->courseService->getCourseById($id));
    }

    public function update(CourseRequest $request, $id)
    {
        $data = $request->validated();
        $course = $this->courseService->updateCourse($id, $data);
        return response()->json($course);
    }

    public function destroy($id)
    {
        $this->courseService->deleteCourse($id);
        return response()->json(['message' => 'Course deleted successfully']);
    }
}