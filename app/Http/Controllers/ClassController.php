<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ClassController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $classes   = Classes::all();
        $teachers  = Teacher::all();
        $subjects  = Subject::all();
        $menuclass = 'active';
        $title     = 'Hapus Kelas!';
        $text      = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.class.index', compact('classes', 'teachers', 'subjects', 'menuclass', 'user'));
    }

    public function create()
    {
        $user      = Auth::user();
        $menuclass = 'active';
        return view('pages.class.create', compact('menuclass', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = Classes::create([
            'name' => $request->input('name'),
        ]);
        // $class = Classes::create($request->only('name', 'teacher_id'));
        // $class->subjects()->attach($request->subjects);
        Alert::success('Hore!', 'Kelas Berhasil Ditambahkan');
        return redirect()->route('classes.index');
    }

    public function addTeacherSubject(Request $request, Classes $class)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subjects'   => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);
        foreach ($request->subjects as $subject_id) {
            $exists = $class->teachers()
                ->wherePivot('teacher_id', $request->teacher_id)
                ->wherePivot('subject_id', $subject_id)
                ->exists();

            if (! $exists) {
                $class->teachers()->attach($request->teacher_id, [
                    'subject_id' => $subject_id,
                ]);
            }
        }

        // $class->teachers()->attach($request->input('teacher_id'));
        // $class->subjects()->attach($request->input('subjects'));
        Alert::success('Hore!', 'Guru dan Mata Pelajaran Berhasil Ditambahkan');
        return redirect()->route('classes.index');
    }

    public function show(Classes $class)
    {
        $user = Auth::user();
        $class->load([
            'teachers' => function ($query) {
                $query->with('subjects');
            },
            'students',
            'materials',
        ]);

        $menuclass = 'acitve';
        return view('pages.class.show', compact('class', 'menuclass', 'user'));
    }

    public function edit(Classes $class)
    {
        $user      = Auth::user();
        $teachers  = Teacher::all();
        $subjects  = Subject::all();
        $menuclass = 'active';
        $class->load('subjects');
        return view('pages.class.edit', compact('class', 'teachers', 'subjects', 'menuclass', 'user'));
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subjects'   => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);
        $class->update($request->only('name', 'teacher_id'));
        $class->subjects()->sync($request->subjects);
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