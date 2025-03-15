<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $students    = Student::with(['user', 'class'])->get();
        $menustudent = 'active';
        $title       = 'Hapus Data Siswa!';
        $text        = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.student.index', compact('students', 'menustudent', 'user'));
    }

    public function create()
    {
        $user        = Auth::user();
        $menustudent = 'active';
        $classes     = Classes::all();
        return view('pages.student.create', compact('classes', 'menustudent', 'user'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role'     => 'siswa',
        ]);
        Student::create([
            'name'     => $request->input('name'),
            'class_id' => $request->input('class_id'),
            'user_id'  => $user->id,
        ]);
        Alert::success('Hore!', 'Peserta Didik Berhasil Ditambahkan');
        return redirect()->route('students.index');
    }

    public function edit(Student $student)
    {
        $user        = Auth::user();
        $menustudent = 'active';
        $classes     = Classes::all();
        return view('pages.student.edit', compact('student', 'classes', 'menustudent', 'user'));
    }

    public function update(Request $request, Student $student)
    {
        $student->name     = $request->input('name');
        $student->class_id = $request->input('class_id');
        $student->save();

        $user        = $student->user;
        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        Alert::success('Hore!', 'Peserta Didik Berhasil Diperbarui');
        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index');
    }

    public function studentclass()
    {
        $user        = Auth::user();
        $student     = $user->student;
        $class       = $student->class;
        $students    = $class->students;
        $menustudent = 'active';
        return view('pages.student.show', compact('class', 'students', 'user', 'menustudent'));
    }

    public function showSubject()
    {
        $menusubject = 'active';
        $user        = Auth::user();
        $student     = $user->student;
        $class       = $student->class;
        if (! $class) {
            return redirect()->route('dashboard')->with('error', 'Class not found for this student.');
        }
        $subjects = $class->subjects;
        $teacher  = $class->teacher;
        return view('pages.student.showsubject', compact('subjects', 'user', 'menusubject', 'teacher'));

    }

    public function showAssignment()
    {
        $user    = Auth::user();
        $student = $user->student;
        $class   = $student->class;
        if (! $class) {
            return redirect()->route('dashboard')->with('error', 'Class not found for this student.');
        }
        $subjects       = $class->subjects;
        $teacher        = $class->teacher;
        $assignments    = $class->assignments;
        $submissions    = Submission::where('student_id', $student->id)->get();
        $menuassignment = 'active';

        return view('pages.student.showassignment', compact('user', 'menuassignment', 'assignments', 'submissions'));
    }

}