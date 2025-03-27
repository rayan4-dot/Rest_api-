<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    public function getAllCourses($search = null, $categoryId = null)
    {
        $query = Course::with('category', 'mentor', 'subcategory');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }

    public function getCourseById($id)
    {
        return Course::with('category', 'mentor', 'subcategory')->findOrFail($id);
    }

    public function createCourse(array $data)
    {
        return Course::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'price' => $data['price'] ?? null,
            'mentor_id' => $data['mentor_id'],
            
        ]);
    }

    public function updateCourse($id, array $data)
    {
        $course = Course::findOrFail($id);

        if ($course->mentor_id !== Auth::id()) {
            throw new \Exception('Unauthorized', 403);
        }

        $course->update([
            'title' => $data['title'] ?? $course->title,
            'description' => $data['description'] ?? $course->description,
            'status' => $data['status'] ?? $course->status,
            'category_id' => $data['category_id'] ?? $course->category_id,
            'subcategory_id' => isset($data['subcategory_id']) ? $data['subcategory_id'] : $course->subcategory_id,
            'price' => isset($data['price']) ? $data['price'] : $course->price,
        ]);

        return $course->load('category', 'mentor', 'subcategory'); 
        }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);

        if ($course->mentor_id !== Auth::id()) {
            throw new \Exception('Unauthorized', 403);
        }

        $course->delete();
    }
}