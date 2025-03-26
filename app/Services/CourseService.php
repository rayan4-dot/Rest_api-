<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterface;

class CourseService
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses($search = null, $categoryId = null)
    {
        return $this->courseRepository->getAll([], $search, $categoryId);
    }

    public function getCourseById($id)
    {
        return $this->courseRepository->findById($id, ['category']);
    }

    public function createCourse(array $data)
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse($id, array $data)
    {
        return $this->courseRepository->update($id, $data);
    }

    public function deleteCourse($id)
    {
        return $this->courseRepository->delete($id);
    }
}