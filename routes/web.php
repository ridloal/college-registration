<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty.index');

    // Route::get('/registration', [RegistrationController::class, 'index'])->name('registration.index');
    // Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');

    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/top-gpa', [StudentController::class, 'topGPA'])->name('student.top-gpa');
    Route::get('/student/top-rank-gpa', [StudentController::class, 'topRankGPA'])->name('student.top-rank-gpa');
});

Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/student-dashboard', [StudentDashboardController::class, 'index'])->name('student-dashboard');
});

require __DIR__.'/auth.php';
