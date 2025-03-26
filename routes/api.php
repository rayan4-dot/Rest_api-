<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\VideoController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use App\Http\Controllers\Api\V1\SubcategoryController;
use App\Http\Controllers\Api\V3\AdminController;
use App\Http\Controllers\Api\V3\BadgeController;
use App\Http\Controllers\Api\V3\MentorController;
use App\Http\Controllers\Api\V3\StudentController;
use App\Http\Controllers\Api\V3\PaymentController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']); 


        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
        Route::post('/courses', [CourseController::class, 'store'])->middleware('role:mentor');
        Route::put('/courses/{id}', [CourseController::class, 'update'])->middleware('role:mentor');
        Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->middleware('role:mentor');


        Route::get('/courses/{courseId}/videos', [VideoController::class, 'index']);
        Route::post('/courses/{courseId}/videos', [VideoController::class, 'store'])->middleware('role:mentor');
        Route::get('/courses/{courseId}/videos/{videoId}', [VideoController::class, 'show']);
        Route::put('/courses/{courseId}/videos/{videoId}', [VideoController::class, 'update'])->middleware('role:mentor');
        Route::delete('/courses/{courseId}/videos/{videoId}', [VideoController::class, 'destroy'])->middleware('role:mentor');


        Route::get('/tags', [TagController::class, 'index']);
        Route::post('/tags', [TagController::class, 'store'])->middleware('role:admin');
        Route::put('/tags/{id}', [TagController::class, 'update'])->middleware('role:admin');
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])->middleware('role:admin');


        Route::get('/subcategories', [SubcategoryController::class, 'index']);
        Route::get('/subcategories/{id}', [SubcategoryController::class, 'index']); // Should this be 'show'?
        Route::post('/subcategories', [SubcategoryController::class, 'store'])->middleware('role:admin');
        Route::put('/subcategories/{id}', [SubcategoryController::class, 'update'])->middleware('role:admin');
        Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy'])->middleware('role:admin');


        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:admin');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('role:admin');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('role:admin');



Route::post('/courses/{courseId}/enroll', [EnrollmentController::class, 'enroll'])->middleware('role:student');
Route::delete('/enrollments/{enrollmentId}', [EnrollmentController::class, 'unenroll'])->middleware('role:student'); // New
Route::post('/enrollments/{enrollmentId}/progress', [EnrollmentController::class, 'progress'])->middleware('role:student');
Route::get('/enrollments', [EnrollmentController::class, 'index'])->middleware('role:student');
Route::get('/enrollments/{enrollmentId}', [EnrollmentController::class, 'show'])->middleware('role:student');


        Route::prefix('users')->group(function () {
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('role:admin');
        });


        Route::prefix('roles')->middleware('role:admin')->group(function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/', [RoleController::class, 'store']);
            Route::put('/{id}', [RoleController::class, 'update']);
            Route::delete('/{id}', [RoleController::class, 'destroy']);
        });
    });
});

Route::prefix('v3')->middleware('auth:sanctum')->group(function () {

    Route::prefix('students')->group(function () {
        Route::get('/{id}/courses', [StudentController::class, 'courses']);
        Route::get('/{id}/progress', [StudentController::class, 'progress']);
        Route::get('/{id}/badges', [StudentController::class, 'badges']);
    });


    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/mentors', [MentorController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/admin/stats', [AdminController::class, 'stats'])->middleware('role:admin');


    Route::post('/badges', [BadgeController::class, 'store'])->middleware('role:admin');
    Route::put('/badges/{id}', [BadgeController::class, 'update'])->middleware('role:admin');
    Route::delete('/badges/{id}', [BadgeController::class, 'destroy'])->middleware('role:admin');
    Route::post('/students/{id}/award-badges', function ($id) {
        $service = app(\App\Services\BadgeService::class);
        $service->awardBadges($id);
        return response()->json(['message' => 'Badges awarded for user ' . $id]);
    })->middleware('role:admin');


});

Route::prefix('v3')->group(function () {
    // Public success endpoint for Stripe redirect
    Route::get('/payments/success', [PaymentController::class, 'success']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/payments/checkout', [PaymentController::class, 'checkout'])->middleware('role:student');
        Route::get('/payments/status/{id}', [PaymentController::class, 'status']);
        Route::get('/payments/history', [PaymentController::class, 'history']);
    });
});