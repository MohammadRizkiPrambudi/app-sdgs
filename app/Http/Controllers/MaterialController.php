<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        // Ambil kombinasi kelas & mapel yang diajar guru
        $classSubjects = DB::table('class_teacher')
            ->where('teacher_id', $teacher->id)
            ->join('classes', 'class_teacher.class_id', '=', 'classes.id')
            ->join('subjects', 'class_teacher.subject_id', '=', 'subjects.id')
            ->select('classes.id as class_id', 'classes.name as class_name',
                'subjects.id as subject_id', 'subjects.name as subject_name')
            ->get();

        $menumaterial = 'active';
        $title        = 'Hapus Materi!';
        $text         = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.material.index', compact('classSubjects', 'menumaterial', 'user'));
    }

    public function create(Request $request)
    {
        $user      = Auth::user();
        $classId   = $request->query('class_id');
        $subjectId = $request->query('subject_id');

        $class        = Classes::findOrFail($classId); // Sesuaikan nama modelnya
        $subject      = Subject::findOrFail($subjectId);
        $menumaterial = 'active';
        return view('pages.material.create', compact('class', 'subject', 'menumaterial', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'video_url'  => 'nullable|url',
        ]);

        $teacher = Auth::user()->teacher;

        // Cek apakah guru memang mengajar mapel tersebut di kelas itu
        $isAuthorized = \DB::table('class_teacher')
            ->where('teacher_id', $teacher->id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if (! $isAuthorized) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menambahkan materi untuk kelas dan mapel ini.');
        }

        $video_url = $request->input('video_url');
        if (Str::contains($video_url, 'watch?v=')) {
            $embed_url = preg_replace('/watch\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $video_url);
        } else {
            $embed_url = $video_url;
        }

        Material::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
            'video_url'  => $embed_url,
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
        $user    = Auth::user();
        $teacher = $user->teacher;

        // Cek apakah guru mengajar mapel ini di kelas ini
        $mengajar = DB::table('class_teacher')
            ->where('class_id', $material->class_id)
            ->where('subject_id', $material->subject_id)
            ->where('teacher_id', $teacher->id)
            ->exists();

        if (! $mengajar) {
            return redirect()->route('materials.index')->with('error', 'Anda tidak berhak mengedit materi ini.');
        }

        $menumaterial = 'active';
        return view('pages.material.edit', compact('material', 'menumaterial', 'user'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'video_url' => 'nullable|url',
        ]);

        $video_url = $request->input('video_url');
        if ($video_url && Str::contains($video_url, 'watch?v=')) {
            $video_url = preg_replace('/watch\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $video_url);
        }

        $material->update([
            'title'     => $request->title,
            'content'   => $request->content,
            'video_url' => $video_url,
        ]);

        Alert::success('Berhasil', 'Materi berhasil diperbarui!');
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

        // Ambil materi berdasarkan kelas siswa
        $materials = $subject->materials()->where('class_id', $class->id)->get();
        return view('pages.material.bysubject', compact('subject', 'materials', 'user', 'subjectname', 'menusubject'));
    }

}