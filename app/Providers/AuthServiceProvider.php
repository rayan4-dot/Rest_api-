<?php

namespace App\Providers;

use App\Models\Tag; 
use App\Models\Course;
use App\Models\Category;
use App\Policies\TagPolicy; 
use App\Policies\CoursePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\EnrollmentPolicy;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les modèles et leurs policies associées.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Tag::class => TagPolicy::class,
        Category::class => CategoryPolicy::class,
        Course::class => CoursePolicy::class,
        Enrollment::class => EnrollmentPolicy::class,

    ];

    /**

     */
    public function boot(): void
    {
        $this->registerPolicies();


        Gate::define('manage-tags', function ($user) {
            return $user->hasPermissionTo('manage-tags');
        });
    
        Gate::define('manage-categories', function ($user) {
            return $user->hasPermissionTo('manage-categories');
        });

        Gate::define('enroll', [EnrollmentPolicy::class, 'enroll']);
    
        
            // for the fucking courses 
            Gate::define('create-courses', function ($user) {
                return $user->hasPermissionTo('manage-courses');
            });
            
            Gate::define('update-courses', function ($user, Course $course) {
                return $user->hasPermissionTo('manage-courses');
            });
            
            Gate::define('delete-courses', function ($user, Course $course) {
                return $user->hasPermissionTo('manage-courses');
            });


    }
}