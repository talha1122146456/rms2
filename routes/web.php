<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes handle course listings, enrollments, and authentication.
| Make sure your controllers exist under App\Http\Controllers.
|
*/




Route::get('/about', [DashboardController::class, 'write'])->name('about');







// 🔹 Redirect home to /courses
Route::redirect('/', '/courses');

// 🔹 Course Routes
Route::get('/courses/search', [CourseController::class, 'search'])->name('courses.search');
Route::resource('courses', CourseController::class);

// Alternate course list (for non-admin view)
Route::get('/courses-alt', [CourseController::class, 'index1'])->name('courses.index1');

// 🔹 Enrollment Routes (only for authenticated users)
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])
        ->name('courses.enroll');

    Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])
        ->name('courses.my');

    Route::get('/my-courses/search', [EnrollmentController::class, 'searchMy'])
        ->name('courses.searchMy');
});

// 🔹 Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
