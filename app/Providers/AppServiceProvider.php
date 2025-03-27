<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;


use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\SubcategoryRepositoryInterface;
use App\Interfaces\TagRepositoryInterface;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\VideoRepositoryInterface;
use App\Interfaces\EnrollmentRepositoryInterface;


use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\CourseRepository;
use App\Repositories\VideoRepository;
use App\Repositories\EnrollmentRepository;
use App\Interfaces\BadgeRepositoryInterface;
use App\Repositories\BadgeRepository;
use App\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubcategoryRepositoryInterface::class, SubcategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
        $this->app->bind(EnrollmentRepositoryInterface::class, EnrollmentRepository::class);
        $this->app->bind(BadgeRepositoryInterface::class, BadgeRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Route::aliasMiddleware('role', RoleMiddleware::class);

    }
}
