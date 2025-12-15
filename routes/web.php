<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\GradeController;



// Trang đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// Trang admin (chỉ admin mới vào được)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/user/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.user.updateStatus');
});



// Trang user
Route::middleware(['auth'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/calendar', [UserController::class, 'calendar'])->name('user.calendar');
    Route::get('/user/statistics', [StatisticsController::class, 'index'])->name('user.statistics');

    Route::get('/user/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/user/task/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/user/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::post('/user/task/{id}/update', [TaskController::class, 'update'])->name('task.update');
    Route::get('/user/task/{id}/delete', [TaskController::class, 'destroy'])->name('task.delete');

    Route::get('/user/grades', [GradeController::class, 'index'])->name('user.grades.index');
    Route::post('/user/grades', [GradeController::class, 'store'])->name('user.grades.store');
    Route::put('/user/grades/{id}', [GradeController::class, 'update'])->name('user.grades.update');
    Route::delete('/user/grades/{id}', [GradeController::class, 'destroy'])->name('user.grades.destroy');

});




Route::get('/', function () {
    return redirect()->route('login');
});

