<?php

namespace App\Repositories;

use App\Models\Video;
use App\Interfaces\VideoRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class VideoRepository implements VideoRepositoryInterface
{
    public function all($courseId = null)
    {
        $query = Video::query();
        if ($courseId) {
            $query->where('course_id', $courseId);
        }
        return $query->get();
    }


    public function store(array $data)
    {
        return Video::create($data);
    }

    public function show($id)
    {
        return Video::findOrFail($id);
    }

    public function showForCourse($videoId, $courseId)
    {

        return Video::where('id', $videoId)
                    ->where('course_id', $courseId)
                    ->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $video = Video::findOrFail($id);
        $video->update($data);
        return $video;
    }

    public function destroy($id)
    {
        return Video::destroy($id);
    }
}
