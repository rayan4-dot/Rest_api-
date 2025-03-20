<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentResource;
use App\Http\Resources\EnrollmentCollection;
use App\Models\Enrollment;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EnrollmentController extends Controller
{
    public function __construct(
        private EnrollmentRepositoryInterface $enrollmentRepository
    ) {}

    /**

     */
    public function enroll(int $courseId)
    {

        if (!Gate::allows('enroll')) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to enroll in this course'
            ], 403);
        }
    
        $userId = auth('sanctum')->id();
        $enrollment = $this->enrollmentRepository->enroll($userId, $courseId);
    
        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course'
            ], 400);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Course enrollment request submitted successfully',
            'data' => new EnrollmentResource($enrollment->load(['user', 'course']))
        ], 201);


        return $user->hasPermissionTo('enroll');

    }

    /**

     */
    public function getEnrollmentsByCourse(int $courseId)
    {
        $enrollments = $this->enrollmentRepository->getEnrollmentByCourse($courseId);
        return response()->json([
            'success' => true,
            'message' => 'Enrollments retrieved successfully',
            'data' => new EnrollmentCollection($enrollments)
        ]);
    }

    /**

     */
    public function updateStatus(Request $request, int $id)
    {
        $enrollment = Enrollment::findOrFail($id);
    

        if (!Gate::allows('updateStatus', $enrollment)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this enrollment'
            ], 403);
        }
    
        $data = $request->validate([
            'status' => ['required', 'in:pending,rejected,accepted']
        ]);
    
        $enrollment = $this->enrollmentRepository->updateStatus($id, $data['status']);
    
        return response()->json([
            'success' => true,
            'message' => 'Enrollment status updated successfully',
            'data' => new EnrollmentResource($enrollment->load(['user', 'course']))
        ], 200);
    }

    /**
     */
    public function myEnrollments()
    {
        $enrollments = $this->enrollmentRepository->getEnrollmentByUser(auth('sanctum')->id());
        return response()->json([
            'success' => true,
            'data' => new EnrollmentCollection($enrollments)
        ]);
    }

    /**
     * Delete an enrollment.
     */
    public function destroy(int $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        // Check if the user is authorized to delete the enrollment
        if (!Gate::allows('delete', $enrollment)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this enrollment'
            ], 403);
        }

        $deleted = $this->enrollmentRepository->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the enrollment'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully'
        ]);
    }
}