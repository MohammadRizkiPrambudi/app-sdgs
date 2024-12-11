<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $type_menu = '';
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('pages.subject.index', compact('subjects', 'type_menu'));
    }

    public function create()
    {
        $type_menu = '';
        return view('pages.subject.create', compact('type_menu'));
    }

    public function store(Request $request)
    {
        Subject::create($request->all());
        Alert::success('Hore!', 'Mata Pelajaran Berhasil Ditambahkan');
        return redirect()->route('subjects.index');
    }

    public function edit(Subject $subject)
    {
        $type_menu = '';
        return view('pages.subject.edit', compact('subject', 'type_menu'));
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
