<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api.header.check')->group(function () {
    Route::post('/magic-link', [MagicLinkController::class, 'send'])
        ->name('api.magic-link.send')->middleware("throttle:20,60");

    Route::post("create-user-and-attach-course", [CourseController::class, 'createUserAndAttachCourse']);
});
