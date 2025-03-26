<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function findById($id)
    {
        return Payment::findOrFail($id);
    }

    public function findByStripeTransactionId($stripeId)
    {
        return Payment::where('stripe_transaction_id', $stripeId)->firstOrFail();
    }

    public function getUserPayments($userId)
    {
        return Payment::where('user_id', $userId)->with('course:title,id')->get();
    }

    public function getAll()
    {
        return Payment::all();
    }
}