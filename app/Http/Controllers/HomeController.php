<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Material;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Submission;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'siswa':
                return redirect()->route('student.dashboard');
            case 'guru':
                return redirect()->route('teacher.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect('/');
        }
    }

    public function studentDashboard()
    {
        $user = Auth::user();
        $student = $user->student;
        $class = $student->class;
        if (!$class) {
            return redirect()->route('dashboard')->with('error', 'Class not found for this student.');
        }
        $subjects = $class->subjects;
        $teacher = $class->teacher;
        $assignments = $class->assignments;

        // Menghitung progres pengumpulan tugas
        $submissionProgress = $assignments->map(function ($assignment) use ($student) {
            $submitted = Submission::where('assignment_id', $assignment->id)->where('student_id', $student->id)->exists();return $submitted ? 1 : 0;
        });

        // Menghitung nilai rata-rata per mata pelajaran
        $subjectGrades = $subjects->map(function ($subject) use ($student) {
            $assignments = $subject->assignments()->where('class_id', $student->class_id)->get();
            $totalGrades = 0;
            $count = 0;
            foreach ($assignments as $assignment) {$submission = $assignment->submissions()->where('student_id', $student->id)->first();
                if ($submission && $submission->grade !== null) {
                    $totalGrades += $submission->grade;
                    $count++;
                }}
            return $count > 0 ? round($totalGrades / $count) : 0;
        });
        $submissions = Submission::where('student_id', $student->id)->get();
        $menudashboard = 'active';
        return view('pages.student.dashboard', compact('class', 'subjects', 'teacher', 'user', 'menudashboard', 'assignments', 'submissionProgress', 'subjectGrades', 'submissions'));
    }

    public function teacherDashboard()
    {
        $menudashboard = 'active';
        $user = Auth::user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher not found.');
        }
        $classes = $teacher->classes;
        $assignments = Assignment::whereHas('class', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('submissions')->get();

        $assignmentGrades = $assignments->map(function ($assignment) {$totalGrades = $assignment->submissions->sum('grade'); $submissionCount = $assignment->submissions->count();return $submissionCount > 0 ? round($totalGrades / $submissionCount) : 0;});

        $submissionProgress = $assignments->map(function ($assignment) {$submitted = $assignment->submissions->count(); $totalStudents = $assignment->class->students->count();return [$submitted, $totalStudents - $submitted];});

        return view('pages.teacher.dashboard', compact('classes', 'assignments', 'teacher', 'user', 'assignmentGrades', 'submissionProgress', 'menudashboard'));
    }

    public function adminDashboard()
    {
        $user = Auth::user();
        $total_students = Student::count();
        $total_teachers = Teacher::count();
        $total_classes = Classes::count();
        $total_subjects = Subject::count();
        $total_materi = Material::count();
        $menudashboard = 'active';
        return view('pages.user.dashboard', compact('total_students', 'total_teachers', 'total_classes', 'menudashboard', 'total_subjects', 'user', 'total_materi'));
    }

}