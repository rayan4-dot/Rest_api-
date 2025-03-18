<?php
namespace App\Providers;

use App\Repositories\TagRepository;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

 


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}



// Illuminate\Support\ServiceProvider

// <?php
// abstract class ServiceProvider { }
// @property array<string, string> $bindings
// All of the container bindings that should be registered.

// @property array<array-key, string> $singletons
// All of the singletons that should be registered.
