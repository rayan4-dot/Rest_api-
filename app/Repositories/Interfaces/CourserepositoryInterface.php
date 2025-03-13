<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function getAllCourses();
    public function getCourseById($id);
    public function createCourse(array $data);
    public function updateCourse($id, array $data);
    public function deleteCourse($id);
}
