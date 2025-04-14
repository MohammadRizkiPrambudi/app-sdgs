<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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
    Route::resource('exams', ExamController::class);
    Route::resource('questions', QuestionController::class);
    Route::post('/classes/{class}/add-teacher-subject', [ClassController::class, 'addTeacherSubject'])->middleware('role:admin')
        ->name('classes.add_teacher_subject');
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('/grades/{class_id}/{subject_id}', [GradeController::class, 'show'])->name('grades.show');
    Route::get('/grades/{assignment}/export-pdf', [GradeController::class, 'exportPdf'])->name('grades.exportPdf');
    Route::get('/exam-grades', [GradeController::class, 'examIndex'])->name('grades.examIndex');
    Route::get('/exam-grades/{exam}', [GradeController::class, 'examShow'])->name('grades.examShow');
    Route::get('/exam-grades/{exam}/export-pdf', [GradeController::class, 'examExportPdf'])->name('grades.examExportPdf');
    Route::get('/teacher/grade-assignment/{assignment}/export-pdf', [TeacherController::class, 'exportAssignmentPdf'])->name('teacher.gradesAssignmentExport');
    Route::get('/teacher/grade-exam/{exam}/export-pdf', [TeacherController::class, 'exportExamGradesPdf'])->name('teacher.examGradesExport');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/teacher/class', [TeacherController::class, 'showClass'])->name('show.class');
    Route::get('/teacher/class/{id}/students', [TeacherController::class, 'classStudents'])->name('class.students');
    Route::resource('assignments', AssignmentController::class);
    Route::post('submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
    Route::get('submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download');
    Route::get('/submission/{submission}/preview', [SubmissionController::class, 'preview'])->name('submissions.preview');
    Route::get('/teacher/class/{id}/students/json', [TeacherController::class, 'studentsJson'])->name('class.students.json');
    Route::get('/teacher/grade-assignment', [TeacherController::class, 'gradeAssignment'])->name('teacher.grades');
    Route::get('/teacher/grade-assignment/{class_id}/{subject_id}', [TeacherController::class, 'showAssignment'])->name('teacher.grades.show');
    Route::get('/teacher/grade-exam', [TeacherController::class, 'examGrades'])->name('teacher.examGrades');
    Route::get('/teacher/grade-exam/{exam}', [TeacherController::class, 'examGradesDetail'])->name('teacher.examGradesDetail');

});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/student/subject', [StudentController::class, 'showSubject'])->name('show.subject');
    Route::get('/student/assignment', [StudentController::class, 'showAssignment'])->name('show.assignment');
    Route::get('assignments/{assignment}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/student/exams', [ExamController::class, 'examStudents'])->name('exams.test');
    Route::post('/exams/{exam}/start', [ExamController::class, 'examStudentStart'])->name('exams.start');
    Route::get('/exams/{exam}/start', [ExamController::class, 'examStudentStart'])->name('exams.start');
    Route::post('/exams/{exam}/submit', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/{exam}/result', [ExamController::class, 'result'])->name('exams.result');
    Route::get('/student/grade-assignment', [StudentController::class, 'gradeAssignment'])->name('student.assignment');
    Route::get('/student/grade-exam', [StudentController::class, 'gradeExam'])->name('student.exam');
});

Route::get('/tes', function () {
    Artisan::call('storage::link');
});