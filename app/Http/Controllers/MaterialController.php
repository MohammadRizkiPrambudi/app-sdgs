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
        $user    = Auth::user();
        $teacher = $user->teacher;

        if (! $teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher not found.');
        }

        $materials = Material::whereHas('class', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        $subjects = Subject::whereHas('classes', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        $menumaterial = 'active';
        $title        = 'Hapus Materi!';
        $text         = "Aapakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.material.index', compact('materials', 'menumaterial', 'user', 'subjects'));
    }

    public function create()
    {
        $user         = Auth::user();
        $teacher      = $user->teacher;
        $classes      = $teacher->classes;
        $subjects     = Subject::all();
        $menumaterial = 'active';
        return view('pages.material.create', compact('classes', 'subjects', 'menumaterial', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        $user    = Auth::user();
        $teacher = $user->teacher;
        $class   = Classes::where('id', $request->class_id)->where('teacher_id', $teacher->id)->first();
        $subject = Subject::where('id', $request->subject_id)->first();
        if (! $class) {
            return redirect()->route('materials.create')->with('error', 'You are not authorized to add materials to this class.');
        }

        Material::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'class_id'   => $class->id,
            'subject_id' => $subject->id,
        ]);
        Alert::success('Hore!', 'Materi Berhasil Ditambahkan');
        return redirect()->route('materials.index');
    }

    public function show(Material $material, Request $request)
    {
        $user         = Auth::user();
        $menumaterial = 'active';
        $menusubject  = 'active';
        $words        = preg_split('/\s+/', $material->content);
        $chunks       = [];
        $currentChunk = '';
        $wordCount    = 0;

        foreach ($words as $word) {
            $currentChunk .= $word . ' ';
            $wordCount++;
            if ($wordCount >= 50 && preg_match('/[\n.!?]/', $word)) {
                $chunks[]     = trim($currentChunk);
                $currentChunk = '';
                $wordCount    = 0;
            }
        }
        if (! empty($currentChunk)) {
            $chunks[] = trim($currentChunk);
        }
        $currentPage = $request->query('page', 1);
        if ($user->role == 'admin') {
            return view('pages.material.showadmin', compact('material', 'user', 'menumaterial'));
        } elseif ($user->role == 'siswa') {
            return view('pages.material.showstudent', compact('material', 'user', 'menusubject', 'chunks', 'currentPage'));
        } elseif ($user->role == 'guru') {
            return view('pages.material.showadmin', compact('material', 'user', 'menumaterial'));
        } else {
            return redirect('/')->with('error', 'Akses tidak diizinkan.');
        }
    }

    public function edit(Material $material)
    {
        $user         = Auth::user();
        $classes      = Classes::all();
        $subjects     = Subject::all();
        $menumaterial = 'active';
        return view('pages.material.edit', compact('material', 'classes', 'subjects', 'menumaterial', 'user'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $user    = Auth::user();
        $teacher = $user->teacher;
        $class   = Classes::where('id', $request->class_id)->where('teacher_id', $teacher->id)->first();
        $subject = Subject::where('id', $request->subject_id)->first();

        if (! $class) {
            return redirect()->route('materials.edit', $material->id)->with('error', 'You are not authorized to update materials for this class.');
        }

        $material->update([
            'title'      => $request->title,
            'content'    => $request->content,
            'class_id'   => $class->id,
            'subject_id' => $subject->id,
        ]);

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
        $user        = Auth::user();
        $student     = $user->student;
        $class       = $student->class;
        $subjectname = $subject->name;
        $menusubject = 'active';
        $materials   = $subject->materials()->whereIn('class_id', $subject->classes->pluck('id'))->get();
        return view('pages.material.bysubject', compact('subject', 'materials', 'user', 'subjectname', 'menusubject'));
    }

}