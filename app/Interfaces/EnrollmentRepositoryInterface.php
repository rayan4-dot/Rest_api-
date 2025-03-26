<?php

namespace App\Interfaces;

interface EnrollmentRepositoryInterface
{
    public function enroll($userId, $courseId);
    public function updateProgress($enrollmentId, $progress);
    public function getAll();
    public function findById($id);
}
