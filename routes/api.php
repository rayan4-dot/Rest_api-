<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\V1\TagController;
// use App\Http\Controllers\Api\V3\AuthController;
// use App\Http\Controllers\Api\V1\VideoController;
// use App\Http\Controllers\Api\V1\CourseController;
// use App\Http\Controllers\Api\V3\CategoryController;
// use App\Http\Controllers\Api\V1\EnrollmentController;
// use App\Http\Controllers\Api\V1\SubcategoryController;
// use App\Http\Controllers\Api\V3\AdminController;
// use App\Http\Controllers\Api\V3\BadgeController;
// use App\Http\Controllers\Api\V3\MentorController;
// use App\Http\Controllers\Api\V3\StudentController;
// use App\Http\Controllers\Api\V3\PaymentController;
// use App\Http\Controllers\Api\V1\UserController;
// use App\Http\Controllers\Api\V1\RoleController;

// Route::prefix('v1')->group(function () {
    // 🟢 Public Category Routes (no auth)
    // Route::apiResource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // 🟢 Public Tag Routes (no auth)
    // Route::apiResource('tags', TagController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // 🟢 Public Course Routes (no auth for now)
    // Route::get('/courses', [CourseController::class, 'index']);
    // Route::get('/courses/{id}', [CourseController::class, 'show']);
    // Route::put('/courses/{id}', [CourseController::class, 'update']);
    // Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

    // 🟢 Make the course creation route public (no auth)
    // Route::post('/courses', [CourseController::class, 'store']);  // Removed 'auth:sanctum' middleware

    // 🔒 Protected Routes (keep them as is)
    // Route::middleware('auth:sanctum')->group(function () {
        // 🔑 Authentication routes
        // Route::post('/logout', [AuthController::class, 'logout']);
        // Route::get('/profile', [AuthController::class, 'profile']);

        // 🟡 Protected Course Routes (for authenticated users only)
//         Route::put('/courses/{id}', [CourseController::class, 'update']);
//         Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
//     });
// });

// Route::prefix('v3')->group(function () {

//     Route::apiResource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    
//     Route::get('/tags', [TagController::class, 'index']);
//     Route::get('/tags/{id}', [TagController::class, 'show']);

//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);

//     Route::get('/payments/success', [PaymentController::class, 'success']);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('/payments/checkout', [PaymentController::class, 'checkout'])->middleware('role:student');
//         Route::get('/payments/status/{id}', [PaymentController::class, 'status']);
//         Route::get('/payments/history', [PaymentController::class, 'history']);

//         Route::prefix('students')->group(function () {
//             Route::get('/{id}/courses', [StudentController::class, 'courses']);
//             Route::get('/{id}/progress', [StudentController::class, 'progress']);
//             Route::get('/{id}/badges', [StudentController::class, 'badges']);
//         });

//         Route::get('/courses', [CourseController::class, 'index']);
//         Route::get('/mentors', [MentorController::class, 'index']);
//         Route::get('/students', [StudentController::class, 'index']);
//         Route::get('/admin/stats', [AdminController::class, 'stats'])->middleware('role:admin');

//         Route::post('/badges', [BadgeController::class, 'store'])->middleware('role:admin');
//         Route::put('/badges/{id}', [BadgeController::class, 'update'])->middleware('role:admin');
//         Route::delete('/badges/{id}', [BadgeController::class, 'destroy'])->middleware('role:admin');

//         Route::post('/students/{id}/award-badges', function ($id) {
//             $service = app(\App\Services\BadgeService::class);
//             $service->awardBadges($id);
//             return response()->json(['message' => 'Badges awarded for user ' . $id]);
//         })->middleware('role:admin');
//     });
// });





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\VideoController;
use App\Http\Controllers\Api\V3\BadgeController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V3\MentorController;
use App\Http\Controllers\Api\V3\PaymentController;
use App\Http\Controllers\Api\V3\StudentController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use App\Http\Controllers\Api\V1\SubcategoryController;

Route::prefix('v1')->group(function () {
    Route::get('/stats/courses', [AdminController::class, 'courseStats']);
    Route::get('/stats/categories', [AdminController::class, 'categoryStats']);
    Route::get('/stats/tags', [AdminController::class, 'tagStats']);

    Route::apiResource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);


    Route::apiResource('tags', TagController::class)->only(['index', 'show', 'store', 'update', 'destroy']);


    Route::apiResource('courses', CourseController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
});

Route::prefix('v3')->group(function () {
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{id}', [TagController::class, 'show']);

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/payments/success', [PaymentController::class, 'success']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/payments/checkout', [PaymentController::class, 'checkout'])->middleware('role:student');
        Route::get('/payments/status/{id}', [PaymentController::class, 'status']);
        Route::get('/payments/history', [PaymentController::class, 'history']);

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
});