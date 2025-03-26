<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Badge;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method \Laravel\Cashier\SubscriptionBuilder newSubscription(string $name, string $price)
 * @method \Stripe\PaymentIntent charge(int $amount, string $paymentMethod, array $options = [])
 * @method \Stripe\PaymentMethod|null defaultPaymentMethod()
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */

    
    use HasFactory,HasApiTokens, Notifiable,HasRoles,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')
                    ->withPivot('progress_status')
                    ->withTimestamps();
    }


    // Mentor-created courses
    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }
    

    // Badges
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withPivot('awarded_at');
    }

}
