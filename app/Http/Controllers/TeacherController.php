<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $type_menu = '';
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('pages.teacher.index', compact('teachers', 'type_menu'));
    }
    public function create()
    {
        $type_menu = '';
        return view('pages.teacher.create', compact('type_menu'));
    }

    public function store(Request $request)
    {
        $teacher = new Teacher;
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        $teacher->password = Hash::make($request->input('password'));
        $teacher->save();
        Alert::success('Hore!', 'Guru Berhasil Ditambahkan');
        return redirect()->route('teachers.index');
    }

    public function show(Teacher $teacher)
    {
        return view('pages.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $type_menu = '';
        return view('pages.teacher.edit', compact('teacher', 'type_menu'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->input('password'));
        }

        $teacher->save();
        Alert::success('Hore!', 'Guru Berhasil Diperbarui');
        return redirect()->route('teachers.index');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index');
    }

}
