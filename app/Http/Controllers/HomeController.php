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
        $user    = Auth::user();
        $student = $user->student;
        $class   = $student->class;
        if (! $class) {
            return redirect()->route('dashboard')->with('error', 'Class not found for this student.');
        }
        $subjects    = $class->subjects;
        $teacher     = $class->teacher;
        $assignments = $class->assignments;
        $submissions = Submission::where('student_id', $student->id)->get();

        $submissionProgress = ['submitted' => $submissions->count(), 'not_submitted' => $assignments->count() - $submissions->count()];

        // Menghitung nilai rata-rata per mata pelajaran
        $subjectGrades = $subjects->map(function ($subject) use ($student) {
            $assignments = $subject->assignments()->where('class_id', $student->class_id)->get();
            $totalGrades = 0;
            $count       = 0;
            foreach ($assignments as $assignment) {$submission = $assignment->submissions()->where('student_id', $student->id)->first();
                if ($submission && $submission->grade !== null) {
                    $totalGrades += $submission->grade;
                    $count++;
                }}
            return $count > 0 ? round($totalGrades / $count) : 0;
        });
        $menudashboard = 'active';
        return view('pages.student.dashboard', compact('class', 'subjects', 'teacher', 'user', 'menudashboard', 'assignments', 'submissionProgress', 'subjectGrades', 'submissions'));
    }

    public function teacherDashboard()
    {
        $menudashboard = 'active';
        $user          = Auth::user();
        $teacher       = $user->teacher;
        if (! $teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher not found.');
        }
        $classes         = $teacher->classes;
        $teacherClassIds = $teacher->classes->pluck('id'); // relasi teacher ke kelas

        $assignments = Assignment::whereIn('class_id', $teacherClassIds)
            ->with('submissions')->get();

        $assignmentGrades = $assignments->map(function ($assignment) {
            $totalGrades     = $assignment->submissions->sum('grade');
            $submissionCount = $assignment->submissions->count();
            return $submissionCount > 0 ? round($totalGrades / $submissionCount) : 0;
        });

        $submissionProgress = $assignments->map(function ($assignment) {
            $submitted     = $assignment->submissions->count();
            $totalStudents = $assignment->class->students->count();
            return ['submitted' => $submitted, 'not_submitted' => $totalStudents - $submitted];
        });

        return view('pages.teacher.dashboard', compact('classes', 'assignments', 'teacher', 'user', 'assignmentGrades', 'submissionProgress', 'menudashboard'));
    }

    public function adminDashboard()
    {
        $user           = Auth::user();
        $total_students = Student::count();
        $total_teachers = Teacher::count();
        $total_classes  = Classes::count();
        $total_subjects = Subject::count();
        $total_materi   = Material::count();
        $menudashboard  = 'active';

        $assignments = Assignment::with('submissions')->get();
        $classes     = Classes::with('students')->get();
        $subjects    = Subject::all();

        // Menghitung nilai rata-rata per tugas
        $assignmentGrades = $assignments->map(function ($assignment) {
            $totalGrades     = $assignment->submissions->sum('grade');
            $submissionCount = $assignment->submissions->count();
            return $submissionCount > 0 ? round($totalGrades / $submissionCount) : 0;
        });
        // Menghitung progres pengumpulan tugas
        $submissionProgress = $assignments->map(function ($assignment) {
            $submitted     = $assignment->submissions->count();
            $totalStudents = $assignment->class->students->count();
            return ['submitted' => $submitted, 'not_submitted' => $totalStudents - $submitted];
        });

        // Menghitung distribusi nilai tugas siswa
        $gradeDistribution = $assignments->map(function ($assignment) {
            return $assignment->submissions->groupBy('grade')->map(function ($submissions) {
                return $submissions->count();
            });
        });

        // Menghitung rata-rata nilai per mata pelajaran
        $subjectGrades = $subjects->map(function ($subject) {
            $assignments = $subject->assignments;
            $totalGrades = 0;
            $count       = 0;
            foreach ($assignments as $assignment) {
                $totalGrades += $assignment->submissions->sum('grade');
                $count += $assignment->submissions->count();
            }
            return $count > 0 ? round($totalGrades / $count) : 0;
        });

        return view('pages.user.dashboard', compact('total_students', 'total_teachers', 'total_classes', 'menudashboard', 'total_subjects', 'user', 'total_materi', 'assignments', 'classes', 'assignmentGrades', 'submissionProgress', 'gradeDistribution', 'subjectGrades', 'subjects'));
    }

}