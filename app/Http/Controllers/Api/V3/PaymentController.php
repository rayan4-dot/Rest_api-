<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $paymentMethodId = $request->query('payment_method_id');
        $payment = $this->paymentService->checkout($courseId, $paymentMethodId);
        return response()->json($payment, 201);
    }

    public function status($id)
    {
        $payment = $this->paymentService->getStatus($id);
        return response()->json($payment);
    }

    public function history()
    {
        $history = $this->paymentService->getUserHistory();
        return response()->json($history);
    }
}