<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
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
        $student = Auth::user()->student;
        $enrollments = $student->class;
        // Materi kelas siswa jika ada // ...
        return view('student.dashboard', compact('enrollments'));
    }

    public function teacherDashboard()
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher->classes;
        return view('teacher.dashboard', compact('classes'));
    }

    public function adminDashboard()
    {
        $total_students = Student::count();
        $total_teachers = Teacher::count();
        $total_classes = Classes::count();
        $type_menu = '';
        return view('pages.user.dashboard', compact('total_students', 'total_teachers', 'total_classes', 'type_menu'));
    }

}
