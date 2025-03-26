<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'course_id', 'stripe_transaction_id', 'amount', 'status', 'is_subscription'];

}
