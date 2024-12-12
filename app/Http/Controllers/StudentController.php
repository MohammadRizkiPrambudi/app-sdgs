<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('class')->get();
        $type_menu = '';
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('pages.student.index', compact('students', 'type_menu'));
    }

    public function create()
    {
        $type_menu = '';
        $classes = Classes::all();
        return view('pages.student.create', compact('type_menu', 'classes'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'siswa',
        ]);
        Student::create([
            'name' => $request->input('name'),
            'class_id' => $request->input('class_id'),
            'user_id' => $user->id,
        ]);
        Alert::success('Hore!', 'Peserta Didik Berhasil Ditambahkan');
        return redirect()->route('students.index');
    }

    public function edit(Student $student)
    {
        $type_menu = '';
        $classes = Classes::all();
        return view('pages.student.edit', compact('student', 'classes', 'type_menu'));
    }

    public function update(Request $request, Student $student)
    {
        $student->name = $request->input('name');
        $student->class_id = $request->input('class_id');
        $student->save();

        $user = $student->user;
        $user->name = $request->input('name');
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

}
