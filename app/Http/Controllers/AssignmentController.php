<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $assignments = Assignment::whereHas('class', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();
        $menuassignment = 'active';
        return view('pages.assignment.index', compact('assignments', 'user', 'menuassignment'));
    }

    public function create()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $classes = $teacher->classes;
        $subjects = Subject::all();
        $menuassignment = 'active';
        return view('pages.assignment.create', compact('classes', 'user', 'subjects', 'menuassignment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        $user = Auth::user();
        $teacher = $user->teacher;
        $class = Classes::where('id', $request->class_id)->where('teacher_id', $teacher->id)->first();
        $subject = Subject::where('id', $request->subject_id)->first();
        if (!$class) {
            Alert::error('Upps', 'Anda tidak berhak menambah tugas');
            return redirect()->route('assignments.create');
        }
        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $class->id,
            'subject_id' => $subject->id,
        ]);
        Alert::success('Hore!', 'Tugas berhasil Ditambahkan');
        return redirect()->route('assignments.index');
    }
    public function edit(Assignment $assignment)
    {
        $menuassignment = 'active';
        $user = Auth::user();
        $teacher = $user->teacher;
        $classes = $teacher->classes;
        $subjects = Subject::all();
        return view('pages.assignment.edit', compact('assignment', 'classes', 'subjects', 'user', 'menuassignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        $assignment->update($request->all());
        return redirect()->route('assignments.index');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignment.index');
    }

}