<?php

namespace App\Repositories;

use App\Models\Course;
use App\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll($relations = [], $search = null, $categoryId = null)
    {
        return Course::with($relations)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get(); 

    }

    public function findById($id, $relations = [])
    {
        return Course::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        $course = Course::create($data);
        if (isset($data['tags'])) {
            $course->tags()->attach($data['tags']);
        }
        return $course;
    }

    public function update($id, array $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        if (isset($data['tags'])) {
            $course->tags()->sync($data['tags']);
        }
        return $course;
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->tags()->detach();
        $course->delete();
        return true;
    }
}