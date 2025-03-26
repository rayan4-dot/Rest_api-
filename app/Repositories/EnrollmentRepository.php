<?php

namespace App\Repositories;

use App\Models\Enrollment;
use App\Interfaces\EnrollmentRepositoryInterface;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{

    public function getAll()

    {

        return Enrollment::all();

    }



    public function findById($id)

    {

        return Enrollment::find($id);

    }


    public function enroll($userId, $courseId)
    {
        return Enrollment::create([
            'student_id' => $userId,
            'course_id' => $courseId,
            'progress_status' => 'not_started',  
        ]);
    }

    public function updateProgress($enrollmentId, $progress)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->progress = $progress;
        $enrollment->save();

        return $enrollment;
    }

    public function acceptEnrollment($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->status = 'accepted';
        $enrollment->save();

        return $enrollment;
    }
}
