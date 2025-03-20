<?php
namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    /**

     */
    public function enroll(User $user): bool
    {
        return $user->hasRole('student');
    }

    /**

     */
    public function updateStatus(User $user, Enrollment $enrollment): bool
    {
        return in_array($user->role, ['teacher', 'admin']);
    }

    /**

     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->role === 'teacher' || $user->role === 'admin' || $enrollment->user_id === $user->id;    }
}