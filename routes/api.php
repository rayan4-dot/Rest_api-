<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CourseController;

use App\Http\Controllers\api\CategoryController;

Route::apiResource('/tags', TagController::class);
Route::apiResource('courses', CourseController::class);
Route::apiResource('categories', CourseController::class);


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('categories/{categoryId}/subcategories', [CategoryController::class, 'getSubcategories']); 
    Route::get('{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('{id}', [CategoryController::class, 'update']);
    Route::delete('{id}', [CategoryController::class, 'destroy']);
});

