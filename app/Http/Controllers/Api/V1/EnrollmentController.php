<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request, $courseId)
    {
        $student = $request->user();
        $course = Course::findOrFail($courseId);
    
        if ($student->courses()->where('course_id', $courseId)->exists()) {
            return response()->json(['message' => 'Already enrolled'], 400);
        }
    
        if ($course->isFree()) {
            $student->courses()->attach($courseId, ['progress_status' => 'in_progress']);
            return response()->json(['message' => 'Enrolled successfully in free course'], 201);
        }
    
        $payment = Payment::where('user_id', $student->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->first();
    
        if (!$payment) {
            return response()->json(['message' => 'Payment required for this course'], 402);
        }
    
        $student->courses()->attach($courseId, ['progress_status' => 'in_progress']);
        return response()->json(['message' => 'Enrolled successfully after payment'], 201);
    }

    public function progress(Request $request, $enrollmentId)
    {
        $enrollment = Enrollment::where('student_id', $request->user()->id)
            ->where('id', $enrollmentId)
            ->firstOrFail();

        $data = $request->validate([
            'progress_status' => 'required|in:in_progress,completed'
        ]);

        $enrollment->update($data);
        return response()->json($enrollment);
    }

    public function index(Request $request)
    {
        $enrollments = $request->user()->courses()
            ->with('category')
            ->withPivot('progress_status')
            ->get();

        return response()->json($enrollments);
    }

    public function show(Request $request, $enrollmentId)
    {
        $enrollment = Enrollment::where('student_id', $request->user()->id)
            ->where('id', $enrollmentId)
            ->with('course')
            ->firstOrFail();

        return response()->json($enrollment);
    }

    public function unenroll(Request $request, $enrollmentId)
    {
        $enrollment = Enrollment::where('student_id', $request->user()->id)
            ->where('id', $enrollmentId)
            ->firstOrFail();

        $enrollment->delete();
        return response()->json(['message' => 'Unenrolled successfully']);
    }
}