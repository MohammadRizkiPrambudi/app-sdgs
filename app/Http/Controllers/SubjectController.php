<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subjects = Subject::all();
        $menusubject = 'active';
        $title = 'Hapus Mata Pelajaran!';
        $text = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.subject.index', compact('subjects', 'menusubject', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $menusubject = 'active';
        return view('pages.subject.create', compact('menusubject', 'user'));
    }

    public function store(Request $request)
    {
        Subject::create($request->all());
        Alert::success('Hore!', 'Mata Pelajaran Berhasil Ditambahkan');
        return redirect()->route('subjects.index');
    }

    public function show(Subject $subject)
    {
        $user = Auth::user();
        $subject->load('classes', 'materials', 'user');
    }

    public function edit(Subject $subject)
    {
        $user = Auth::user();
        $menusubject = 'active';
        return view('pages.subject.edit', compact('subject', 'menusubject', 'user'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->all());
        Alert::success('Hore!', 'Mata Pelajaran Berhasil Diperbarui');
        return redirect()->route('subjects.index');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        Alert::success('Hore!', 'Mata Pelajaran Berhasil Dihapus');
        return redirect()->route('subjects.index');
    }

}