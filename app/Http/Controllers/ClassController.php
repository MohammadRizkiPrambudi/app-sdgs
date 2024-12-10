<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('teacher', 'subject')->get();
        $type_menu = '';
        return view('pages.class.index', compact('classes', 'type_menu'));
    }
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $type_menu = '';
        return view('pages.class.create', compact('teachers', 'subjects', 'type_menu'));
    }

    public function store(Request $request)
    {
        Classes::create($request->all());
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dibuat');
    }

    public function edit(Classes $class)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $type_menu = '';
        return view('pages.class.edit', compact('class', 'teachers', 'subjects', 'type_menu'));
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($request->all());
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus');
    }

}