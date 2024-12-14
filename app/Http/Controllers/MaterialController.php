<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $materials = Material::all();
        $menumaterial = 'active';
        $title = 'Hapus Materi!';
        $text = "Aapakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.material.index', compact('materials', 'menumaterial', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $classes = Classes::all();
        $subjects = Subject::all();
        $menumaterial = 'active';
        return view('pages.material.create', compact('classes', 'subjects', 'menumaterial', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        Material::create($request->all());
        Alert::success('Hore!', 'Materi Berhasil Ditambahkan');
        return redirect()->route('materials.index');
    }

    public function show(Material $material)
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return view('pages.material.showadmin', compact('material', 'user'));
        } elseif ($user->role == 'siswa') {
            return view('pages.material.showstudent', compact('material', 'user'));
        } else {
            return redirect('/')->with('error', 'Akses tidak diizinkan.');
        }
    }

    public function edit(Material $material)
    {
        $user = Auth::user();
        $classes = Classes::all();
        $subjects = Subject::all();
        $menumaterial = 'active';
        return view('pages.material.edit', compact('material', 'classes', 'subjects', 'menumaterial', 'user'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        $material->update($request->all());
        Alert::success('Hore!', 'Materi Berhasil Diperbarui');
        return redirect()->route('materials.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        Alert::success('Hore!', 'Materi Berhasil Dihapus');
        return redirect()->route('materials.index');
    }

    public function materialsBySubject(Subject $subject)
    {
        $user = Auth::user();
        $student = $user->student;
        $class = $student->class;
        $materials = $subject->materials()->whereIn('class_id', $subject->classes->pluck('id'))->get();
        return view('pages.material.bysubject', compact('subject', 'materials', 'user'));
    }

}