<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Interfaces\VideoRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    protected $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        if (!$course->isEnrolledByStudent($user->id)) {
            return response()->json(['message' => 'You must enroll in the course to view the videos.'], 403);
        }

        return response()->json($this->videoRepository->all($courseId));
    }

    public function store(StoreVideoRequest $request)
    {
        $video = $this->videoRepository->store($request->validated());
        return response()->json($video, 201);
    }

    public function show($courseId, $videoId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        if (!$course->isEnrolledByStudent($user->id)) {
            return response()->json(['message' => 'You must enroll in the course to view the video.'], 403);
        }

        $video = $this->videoRepository->showForCourse($videoId, $courseId);
        return response()->json($video);
    }

    public function update(StoreVideoRequest $request, $id)
    {
        $video = $this->videoRepository->update($request->validated(), $id);
        return response()->json($video);
    }

    public function destroy($id)
    {
        $this->videoRepository->destroy($id);
        return response()->json(['message' => 'Video deleted successfully']);
    }
}