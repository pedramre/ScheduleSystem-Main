<?php

use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);

    Route::group(['prefix' => '/user', 'as' => 'user.', 'middleware' => ['auth']], function () {
        Route::post('/edit', [UserController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => '/job', 'as' => 'job.', 'middleware' => ['auth']], function () {
        Route::post('/create', [JobController::class, 'create'])->name('create');
        Route::post('/edit', [JobController::class, 'edit'])->name('edit');
        Route::post('/delete', [JobController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => '/schedule', 'as' => 'schedule.'], function () {
        Route::post('/create', [ScheduleController::class, 'create'])->name('create');
        Route::post('/edit', [ScheduleController::class, 'edit'])->name('edit');
        Route::post('/delete', [ScheduleController::class, 'delete'])->name('delete');
        Route::post('/status', [ScheduleController::class, 'status'])->name('status');
    });

    Route::group(['prefix' => '/role', 'as' => 'role.'], function () {
        Route::post('/edit', [RoleController::class, 'edit'])->name('edit');
    });

});
