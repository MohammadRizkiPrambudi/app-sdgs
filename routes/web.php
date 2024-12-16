<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
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
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/student/dashboard', [HomeController::class, 'studentDashboard'])->middleware('role:siswa')->name('student.dashboard');
    Route::get('/materials/subject/{subject}', [MaterialController::class, 'materialsBySubject'])->middleware('role:siswa')->name('materials.subject');

    Route::get('/student/student', [StudentController::class, 'StudentClass'])->middleware('role:siswa')->name('student.class');

    Route::get('/teacher/dashboard', [HomeController::class, 'teacherDashboard'])->middleware('role:guru')->name('teacher.dashboard');

    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->middleware('role:admin')->name('admin.dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('subjects', SubjectController::class)->middleware('role:admin');
    Route::resource('teachers', TeacherController::class)->middleware('role:admin');
    Route::resource('students', StudentController::class)->middleware('role:admin');
    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::resource('classes', ClassController::class)->middleware('role:admin');
    Route::resource('materials', MaterialController::class);
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/teacher/class', [TeacherController::class, 'showClass'])->name('show.class');
    Route::get('/teacher/class/{id}/students', [TeacherController::class, 'classStudents'])->name('class.students');
    Route::resource('assignments', AssignmentController::class);
    Route::post('submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
    Route::get('submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/student/subject', [StudentController::class, 'showSubject'])->name('show.subject');
    Route::get('/student/assignment', [StudentController::class, 'showAssignment'])->name('show.assignment');
    Route::get('assignments/{assignment}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
});