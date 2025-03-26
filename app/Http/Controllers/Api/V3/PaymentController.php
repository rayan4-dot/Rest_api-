<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {
        $courseId = $request->query('course_id');
        try {
            $result = $this->paymentService->checkout($courseId);
            return response()->json($result, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return response()->json(['error' => 'Session ID required'], 400);
        }
    
        try {
            $payment = $this->paymentService->handleSuccess($sessionId);
            return response()->json([
                'message' => 'Payment successful, enrolled in course',
                'course_id' => $payment->course_id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($id)
    {
        try {
            $payment = $this->paymentService->getStatus($id);
            return response()->json($payment);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
    
    public function history()
    {
        $history = $this->paymentService->getUserHistory();
        return response()->json($history);
    }
}