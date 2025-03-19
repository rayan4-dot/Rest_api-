<?php
namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAllCourses()
    {
        return Course::with(['category', 'subcategory'])->get();
    }

    public function getCourseById($id)
    {
        return Course::with(['category', 'subcategory'])->findOrFail($id);
    }

    public function createCourse(array $data)
    {
        return Course::create($data);
    }

    public function updateCourse($id, array $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        return $course->delete();
    }
}
