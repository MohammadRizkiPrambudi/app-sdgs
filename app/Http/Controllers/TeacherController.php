<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $teachers    = Teacher::all();
        $menuteacher = 'active';
        $title       = 'Hapus Data Guru!';
        $text        = "Aapakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.teacher.index', compact('teachers', 'menuteacher', 'user'));
    }
    public function create()
    {
        $user        = Auth::user();
        $menuteacher = 'active';
        return view('pages.teacher.create', compact('menuteacher', 'user'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role'     => 'guru',
        ]);

        Teacher::create([
            'name'    => $request->input('name'),
            'user_id' => $user->id,
        ]);

        Alert::success('Hore!', 'Guru Berhasil Ditambahkan');
        return redirect()->route('teachers.index');
    }

    public function edit(Teacher $teacher)
    {
        $user        = Auth::user();
        $menuteacher = 'active';
        return view('pages.teacher.edit', compact('teacher', 'menuteacher', 'user'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->name = $request->input('name');
        $teacher->save();

        $user        = $teacher->user;
        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();
        Alert::success('Hore!', 'Guru Berhasil Diperbarui');
        return redirect()->route('teachers.index');
    }

    public function destroy(Teacher $teacher)
    {
        $user = $teacher->user;
        $teacher->delete();
        $user->delete();
        return redirect()->route('teachers.index');
    }

    public function showClass()
    {
        $menuteacher = 'active';
        $user        = Auth::user();
        $teacher     = $user->teacher;
        $classes     = $teacher->classes;
        return view('pages.teacher.showclass', compact('classes', 'user', 'menuteacher'));
    }

    public function classStudents($classId)
    {
        $menuteacher = 'active';
        $user        = Auth::User();
        $class       = Classes::findOrFail($classId);
        $students    = $class->students;
        return view('pages.teacher.class-students', compact('class', 'students', 'user', 'menuteacher'));
    }

    public function studentsJson($id)
    {
        $class = Classes::with('students.user')->findOrFail($id);
        return response()->json(
            $class->students->map(function ($student) {
                return [
                    'name'  => $student->user->name ?? '-',
                    'email' => $student->user->email ?? '-',
                ];
            })
        );
    }

    public function gradeAssignment(Request $request)
    {
        $user    = Auth::user();
        $teacher = $user->teacher;

        // Ambil kelas dan mapel yang diajar guru ini
        $classIds   = $teacher->classes->pluck('id');
        $subjectIds = $teacher->subjects->pluck('id');

        $classes  = Classes::whereIn('id', $classIds)->get();
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $assignments = [];

        if ($request->filled(['class_id', 'subject_id'])) {
            $assignments = Assignment::where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->withCount('submissions')
                ->get();
        }

        $menugradeassignment = '';
        return view('pages.teacher.gradesassignment', compact(
            'classes', 'subjects', 'assignments', 'user', 'menugradeassignment'
        ));
    }

    public function showAssignment($class_id, $subject_id)
    {
        $user    = Auth::user();
        $class   = Classes::findOrFail($class_id);
        $subject = Subject::findOrFail($subject_id);

        $assignment = Assignment::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->with(['submissions.student'])
            ->firstOrFail();

        $students   = Student::where('class_id', $class_id)->with('user')->get();
        $assignment = Assignment::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->with(['submissions' => function ($query) {
                $query->with('student');
            }])
            ->first();

        $menugradeassignment = '';
        return view('pages.teacher.showgradeassignment', compact('assignment', 'students', 'user', 'menugradeassignment'));
    }

    public function exportAssignmentPdf($assignment_id)
    {

        // Ambil semua submission siswa untuk assignment ini
        $assignment = Assignment::with(['class.students.user', 'subject', 'submissions'])->findOrFail($assignment_id);
        $students   = $assignment->class->students;

        $pdf = Pdf::loadView('pages.teacher.assignment_grade_pdf', [
            'assignment' => $assignment,
            'students'   => $students,
        ]);
        return $pdf->stream('nilai_tugas_' . $assignment->title . '.pdf');
    }

    public function examGrades(Request $request)
    {
        $user      = Auth::user();
        $teacherId = $user->teacher->id;

        $classSubjects = DB::table('class_teacher')
            ->join('classes', 'class_teacher.class_id', '=', 'classes.id')
            ->join('subjects', 'class_teacher.subject_id', '=', 'subjects.id')
            ->where('class_teacher.teacher_id', $teacherId)
            ->select(
                'classes.id as class_id',
                'classes.name as class_name',
                'subjects.id as subject_id',
                'subjects.name as subject_name'
            )
            ->get();

        $classes  = $classSubjects->unique('class_id');
        $subjects = $classSubjects->unique('subject_id');

        $class_id   = $request->class_id;
        $subject_id = $request->subject_id;

        $exams = [];
        if ($class_id && $subject_id) {
            $exams = Exam::withCount(['studentAnswers' => function ($query) {
                $query->select(DB::raw("count(distinct student_id)"));
            }])
                ->where('class_id', $class_id)
                ->where('subject_id', $subject_id)
                ->get();
        }

        $menugradeexam = '';

        return view('pages.teacher.exam_grades', compact('classes', 'subjects', 'class_id', 'subject_id', 'exams', 'user', 'menugradeexam'));
    }

    public function examGradesDetail(Exam $exam)
    {
        $user     = Auth::user();
        $students = Student::where('class_id', $exam->class_id)->get();

        $results = [];
        foreach ($students as $student) {
            $correct = DB::table('student_answers')
                ->where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('is_correct', 1)
                ->count();

            $total = DB::table('questions')->where('exam_id', $exam->id)->count();

            $score = $total > 0 ? round(($correct / $total) * 100) : 0;

            $results[] = [
                'student' => $student,
                'correct' => $correct,
                'total'   => $total,
                'score'   => $score,
            ];
        }
        $menugradeexam = '';

        return view('pages.teacher.exam_grades_detail', compact('exam', 'results', 'user', 'menugradeexam'));
    }

    public function exportExamGradesPdf($examId)
    {
        $exam = Exam::with('class', 'subject')->findOrFail($examId);

        $students = Student::where('class_id', $exam->class_id)->get();

        $questionsCount = $exam->questions()->count();

        $results = [];

        foreach ($students as $student) {
            $correctAnswers = StudentAnswer::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('is_correct', true)
                ->count();

            $score = $questionsCount > 0 ? round(($correctAnswers / $questionsCount) * 100, 2) : 0;

            $results[] = [
                'student' => $student,
                'correct' => $correctAnswers,
                'total'   => $questionsCount,
                'score'   => $score,
            ];
        }

        $pdf = Pdf::loadView('pages.teacher.exam_export_pdf', [
            'exam'    => $exam,
            'results' => $results,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('nilai-ujian-' . Str::slug($exam->title) . '.pdf');
    }

}