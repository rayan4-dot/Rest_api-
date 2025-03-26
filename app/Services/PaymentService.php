<?php

namespace App\Services;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function checkout($courseId, $paymentMethodId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();


        if (!$user->stripe_id) {
            $user->createAsStripeCustomer();
        }

        if ($course->is_subscription) {
            $subscription = $user->newSubscription('default', 'price_xxx')->create($paymentMethodId);
            $payment = $this->paymentRepository->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'stripe_transaction_id' => $subscription->stripe_id,
                'amount' => $course->price,
                'status' => 'completed',
                'is_subscription' => true,
            ]);
        } else {
            $paymentIntent = $user->charge($course->price * 100, $paymentMethodId, [
                'metadata' => ['course_id' => $course->id],
            ]);
            $payment = $this->paymentRepository->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'stripe_transaction_id' => $paymentIntent->id,
                'amount' => $course->price,
                'status' => $paymentIntent->status === 'succeeded' ? 'completed' : 'pending',
                'is_subscription' => false,
            ]);
        }

        return $payment;
    }

    public function getStatus($paymentId)
    {
        return $this->paymentRepository->findById($paymentId);
    }

    public function getUserHistory()
    {
        return $this->paymentRepository->getUserPayments(Auth::id());
    }

    public function getAllTransactions()
    {
        return $this->paymentRepository->getAll();
    }
}