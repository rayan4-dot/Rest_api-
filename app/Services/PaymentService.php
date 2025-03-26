<?php

namespace App\Services;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
        Stripe::setApiKey(env('STRIPE_SECRET')); // Stripe key from .env
    }

 
    public function checkout($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();
    
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            throw new \Exception('Already enrolled in this course');
        }
    
        if ($course->isFree()) {
            throw new \Exception('This course is free—no payment required');
        }
    
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => $course->title],
                    'unit_amount' => (int)($course->price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/api/v3/payments/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/payment/cancel'),
            'metadata' => ['user_id' => $user->id, 'course_id' => $course->id],
        ]);
    
        $payment = $this->paymentRepository->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'stripe_transaction_id' => $session->id,
            'amount' => $course->price,
            'status' => 'pending',
            'is_subscription' => false,
        ]);
    
        return [
            'checkout_url' => $session->url,
            'payment_id' => $payment->id,
        ];
    }
    

    public function handleSuccess($sessionId)
    {
        $session = StripeSession::retrieve($sessionId);
        $payment = $this->paymentRepository->findByStripeTransactionId($sessionId);

        if ($session->payment_status === 'paid' && $payment->status !== 'completed') {
            $payment->update(['status' => 'completed']);
            $user = $payment->student; // Assuming student() relation
            $user->courses()->attach($payment->course_id, ['progress_status' => 'in_progress']);
        }

        return $payment;
    }

    public function getStatus($paymentId)
    {
        $payment = $this->paymentRepository->findById($paymentId);
        if ($payment->user_id !== Auth::id()) {
            throw new \Exception('Unauthorized');
        }
        return [
            'id' => $payment->id,
            'course_id' => $payment->course_id,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'date' => $payment->created_at->toDateTimeString(),
        ];
    }
    
    public function getUserHistory()
    {
        $payments = $this->paymentRepository->getUserPayments(Auth::id());
        return $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'course_title' => $payment->course->title,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'date' => $payment->created_at->toDateTimeString(),
            ];
        });
    }
}