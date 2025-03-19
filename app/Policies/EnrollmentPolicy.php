<?php
namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    /**
     * Determine if the user can enroll in a course.
     */
    public function enroll(User $user): bool
    {
        return $user->hasRole('student');
    }

    /**
     * Determine if the user can update the enrollment status.
     */
    public function updateStatus(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('teacher');
    }

    /**
     * Determine if the user can delete an enrollment.
     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('teacher') || $enrollment->user_id === $user->id;
    }
}