<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
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
        $student = new Student;
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->password = Hash::make($request->input('password'));
        $student->grade = $request->input('grade');
        $student->save();
        Alert::success('Hore!', 'Peserta Didik Berhasil Ditambahkan');
        return redirect()->route('students.index');
    }

    public function edit(Student $student)
    {
        $type_menu = '';
        $classes = Classes::all();
        return view('pages.student.edit', compact('student', 'classes', 'type_menu'));
    }

    public function update()
    {

        $student->name = $request->input('name');
        $student->email = $request->input('email');
        if ($request->filled('password')) {
            $student->password = Hash::make($request->input('password'));
        }
        $student->class_id = $request->input('class_id');
        $student->save();
        Alert::success('Hore!', 'Peserta Didik Berhasil Diperbarui');
        return redirect()->route('students.index');
    }

}
