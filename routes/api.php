<!-- <?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\TagController;
// use App\Http\Controllers\Api\CourseController;
// use App\Http\Controllers\Api\AuthController;

// use App\Http\Controllers\Api\CategoryController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('courses', [CourseController::class, 'store'])->middleware('permission:manage-courses');
//     Route::apiResource('categories', CategoryController::class);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::post('/tags', [TagController::class, 'store'])->middleware('permission:manage-tags');
// // });





// Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route::post('/register', [AuthController::class, 'register']);
// // Route::post('/login', [AuthController::class, 'login']);



// Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index']); 
//     Route::get('{categoryId}/subcategories', [CategoryController::class, 'getSubcategories']); 


//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('/', [CategoryController::class, 'store'])->middleware('can:create,App\Models\Category');
//         Route::put('{id}', [CategoryController::class, 'update'])->middleware('can:update,App\Models\Category');
//         Route::delete('{id}', [CategoryController::class, 'destroy'])->middleware('can:delete,App\Models\Category');
//     });
// }); 



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnrollmentController;


Route::post('/register', [AuthController::class, 'register']);


Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // enrollment 
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->middleware('can:enroll');
    Route::get('/courses/{course}/enrollments', [EnrollmentController::class, 'getEnrollmentsByCourse']);
    Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'updateStatus']);
    Route::get('/enrollments/me', [EnrollmentController::class, 'myEnrollments']);
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy']);

    // course routes
    Route::post('courses', [CourseController::class, 'store'])->middleware('can:create-courses');
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    Route::put('courses/{id}', [CourseController::class, 'update'])->middleware('can:update-courses');
    Route::delete('courses/{id}', [CourseController::class, 'destroy'])->middleware('can:delete-courses');
//tags
    Route::apiResource('/tags', TagController::class)->middleware('can:manage-tags');
}); 


Route::apiResource('categories', CategoryController::class);
Route::get('categories/{categoryId}/subcategories', [CategoryController::class, 'getSubcategories']);

// Route::prefix('categories')->group(function () {
//     Route::get('/', CategoryController::class);
// });
