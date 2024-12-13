<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('teacher', 'subject')->get();
        $type_menu = '';
        $menuclass = 'active';
        $title = 'Hapus Kelas!';
        $text = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.class.index', compact('classes', 'type_menu', 'menuclass'));
    }
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $type_menu = '';
        $menuclass = 'active';
        return view('pages.class.create', compact('teachers', 'subjects', 'type_menu', 'menuclass'));
    }

    public function store(Request $request)
    {
        Classes::create($request->all());
        Alert::success('Hore!', 'Kelas Berhasil Ditambahkan');
        return redirect()->route('classes.index');
    }

    public function edit(Classes $class)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $type_menu = '';
        $menuclass = 'active';
        return view('pages.class.edit', compact('class', 'teachers', 'subjects', 'type_menu', 'menuclass'));
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($request->all());
        Alert::success('Hore!', 'Kelas Berhasil Diperbarui');
        return redirect()->route('classes.index');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        Alert::success('Hore!', 'Kelas Berhasil Dihapus');
        return redirect()->route('classes.index');
    }

}