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
        $user        = Auth::user();
        $teacher     = $user->teacher;
        $assignments = Assignment::whereHas('class.teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })->whereHas('subject.teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })->get();
        $menuassignment = 'active';
        return view('pages.assignment.index', compact('assignments', 'user', 'menuassignment'));
    }

    public function create()
    {
        $user    = Auth::user();
        $teacher = $user->teacher;

        $classes  = $teacher->classes()->distinct()->get();
        $subjects = Subject::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })->distinct()->get();

        $menuassignment = 'active';
        return view('pages.assignment.create', compact('classes', 'user', 'subjects', 'menuassignment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'  => 'required|exists:subjects,id',
        ]);
        $user      = Auth::user();
        $teacher   = $user->teacher;
        $hasAccess = $teacher->classes()
            ->where('classes.id', $request->class_id)
            ->whereHas('subjects', function ($query) use ($request, $teacher) {
                $query->where('subjects.id', $request->subject_id)
                    ->whereHas('teachers', function ($q) use ($teacher) {
                        $q->where('teachers.id', $teacher->id);
                    });
            })->exists();

        if (! $hasAccess) {
            Alert::error('Upps', 'Anda tidak berhak menambah tugas');
            return redirect()->route('assignments.create');
        }
        Assignment::create([
            'title'       => $request->title,
            'description' => $request->description,
            'class_id'    => $request->class_id,
            'subject_id'  => $request->subject_id,
        ]);
        Alert::success('Hore!', 'Tugas berhasil Ditambahkan');
        return redirect()->route('assignments.index');
    }
    public function edit(Assignment $assignment)
    {
        $menuassignment = 'active';
        $user           = Auth::user();
        $teacher        = $user->teacher;
        $classes        = $teacher->classes()->distinct()->get();
        $subjects       = Subject::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })->distinct()->get();
        return view('pages.assignment.edit', compact('assignment', 'classes', 'subjects', 'user', 'menuassignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'  => 'required|exists:subjects,id',
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