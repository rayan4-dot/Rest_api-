<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $courseId)
    {
            
        $isExist = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    
        if ($isExist) {
            return [
                'success' => false,
                'message' => 'You are already enrolled in this course'
            ];
        }
    

        $enrollment = Enrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => 'pending'
        ]);
    
        return [
            'success' => true,
            'message' => 'Course enrollment request submitted successfully',
            'data' => $enrollment
        ];
    }

    public function getEnrollmentByCourse(int $courseId)
    {
        return Enrollment::where('course_id', $courseId)
            ->with(['user', 'course'])
            ->get();
    }

    public function getEnrollmentByUser(int $userId)
    {
        return Enrollment::where('user_id', $userId)
            ->with(['user', 'course'])
            ->get();
    }

    public function getById(int $id)
    {
        return Enrollment::with(['user', 'course'])->find($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => $status]);
        return $enrollment->refresh();
    }

    public function delete(int $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return $enrollment->delete();
    }
}