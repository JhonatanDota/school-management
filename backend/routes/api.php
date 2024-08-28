<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth', [AuthController::class, 'login']);


Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('teachers')->group(function () {
        Route::get('/', [TeacherController::class, 'all']);
        Route::post('/', [TeacherController::class, 'store']);
        Route::get('/{id}', [TeacherController::class, 'show']);
        Route::patch('/{id}', [TeacherController::class, 'update']);
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'all']);
        Route::post('/', [CourseController::class, 'store']);

        Route::get('/{id}', [CourseController::class, 'show']);
    });
});
