<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function getAllCourses(?string $search = null, ?int $categoryId = null)
    {
        $query = Course::query();
        
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query->get();
    }

    public function createCourse(array $data)
    {
        return Course::create($data);
    }

    public function getCourseById($id)
    {
        return Course::findOrFail($id);
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
        $course->delete();
    }
}