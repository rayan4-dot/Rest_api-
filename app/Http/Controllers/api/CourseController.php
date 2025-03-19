<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        return CourseResource::collection($courses);
    }

    public function show($id)
    {
        $course = $this->courseService->getCourseById($id);
        return new CourseResource($course);
    }

    public function store(StoreCourseRequest $request)
    {

        if (!Gate::allows('create-courses')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }


        $course = $this->courseService->createCourse($request->validated());


        if (!$course) {
            return response()->json(['message' => 'Failed to create course'], 500);
        }

        return new CourseResource($course);  
    }
  
    public function update(UpdateCourseRequest $request, $id)
    {
        $course = $this->courseService->getCourseById($id);
    
        if (!Gate::allows('update-courses', $course)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $course = $this->courseService->updateCourse($id, $request->validated());
        return new CourseResource($course);
    }
    
    public function destroy($id)
    {
        $course = $this->courseService->getCourseById($id);
    
        if (!Gate::allows('delete-courses', $course)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $this->courseService->deleteCourse($id);
        return response()->json(['message' => 'Course deleted successfully']);
    }
}