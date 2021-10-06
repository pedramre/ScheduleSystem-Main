<?php

use App\Events\AddSchedule;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


Route::get('/test', function () {
    $schedule = \App\Models\Schedules::where('id',2)->first();
    event(new AddSchedule($schedule));
    return 'done';
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'register']);
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        Route::group(['prefix' => '/user', 'as' => 'user.'], function () {
            Route::get('/', [UserController::class, 'list'])->name('list')->middleware('permission:list user');
            Route::get('/{id}', [UserController::class, 'edit'])->name('edit')->middleware('permission:edit user');
        });

        Route::group(['prefix' => '/job', 'as' => 'job.'], function () {
            Route::get('/', [JobController::class, 'list'])->name('list')->middleware('permission:list job');
            Route::get('/create', [JobController::class, 'create'])->name('create')->middleware('permission:create job');
            Route::get('/{uuid}', [JobController::class, 'edit'])->name('edit')->middleware('permission:edit job');
        });

        Route::group(['prefix' => '/schedule', 'as' => 'schedule.'], function () {
            Route::get('/', [ScheduleController::class, 'list'])->name('list')->middleware('permission:list schedule');
            Route::get('/create', [ScheduleController::class, 'create'])->name('create')->middleware('permission:create schedule');
            Route::get('/{uuid}', [ScheduleController::class, 'edit'])->name('edit')->middleware('permission:edit schedule');
        });

        Route::group(['prefix' => '/role', 'as' => 'role.'], function () {
            Route::get('/', [RoleController::class, 'list'])->name('list')->middleware('permission:list role');
            Route::get('/{id}', [RoleController::class, 'edit'])->name('edit')->middleware('permission:edit role');
        });

    });
});
