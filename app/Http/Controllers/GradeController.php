<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $classes  = Classes::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        $assignments = [];

        if ($request->filled(['class_id', 'subject_id'])) {
            $assignments = Assignment::where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->withCount('submissions')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $menugrade = '';
        return view('pages.grades.index', [
            'classes'         => $classes,
            'subjects'        => $subjects,
            'assignments'     => $assignments,
            'selectedClass'   => $request->class_id,
            'selectedSubject' => $request->subject_id,
            'user'            => $user,
            'menugrade'       => $menugrade,
        ]);
    }

    public function show($class_id, $subject_id)
    {
        $user    = Auth::user();
        $class   = Classes::findOrFail($class_id);
        $subject = Subject::findOrFail($subject_id);

        $assignments = Assignment::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->with(['submissions' => function ($query) {
                $query->with('student')
                    ->orderBy('grade', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        $menugrade = '';

        return view('pages.grades.show', compact('user', 'class', 'subject', 'assignments', 'menugrade'));
    }

    public function exportPdf(Request $request)
    {

        $assignment = Assignment::with(['class', 'subject', 'submissions.student'])->findOrFail($assignment_id);

        $pdf = Pdf::loadView('exports.nilai_per_tugas_pdf', compact('assignment'));
        return $pdf->stream('nilai_' . Str::slug($assignment->title) . '.pdf');
    }

    public function examIndex(Request $request)
    {
        $user          = Auth::user();
        $menuexamgrade = '';
        $classes       = Classes::orderBy('name')->get();
        $subjects      = Subject::orderBy('name')->get();
        $exams         = [];

        if ($request->filled(['class_id', 'subject_id'])) {
            $exams = Exam::where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->orderBy('start_time', 'desc')
                ->get();
        }

        return view('pages.exam_grades.index', compact('classes', 'subjects', 'exams', 'user', 'menuexamgrade'));
    }

    public function examShow(Exam $exam)
    {
        $user          = Auth::user();
        $menuexamgrade = '';
        // Ambil semua siswa dalam kelas ujian
        $students = Student::where('class_id', $exam->class_id)->with('user')->get();

        // Hitung nilai setiap siswa
        foreach ($students as $student) {
            $student->correct_answers = StudentAnswer::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('is_correct', true)
                ->count();

            $student->total_questions = Question::where('exam_id', $exam->id)->count();

            $student->score = $student->total_questions > 0
            ? round(($student->correct_answers / $student->total_questions) * 100, 2)
            : 0;
        }

        return view('pages.exam_grades.show', compact('exam', 'students', 'user', 'menuexamgrade'));
    }

    public function examExportPdf(Exam $exam)
    {
        $students = Student::where('class_id', $exam->class_id)->get();

        foreach ($students as $student) {
            $student->correct_answers = StudentAnswer::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('is_correct', true)
                ->count();

            $student->total_questions = Question::where('exam_id', $exam->id)->count();

            $student->score = $student->total_questions > 0
            ? round(($student->correct_answers / $student->total_questions) * 100, 2)
            : 0;
        }

        $pdf = Pdf::loadView('pages.exam_grades.exam_grades_pdf', [
            'exam'     => $exam,
            'students' => $students,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Nilai_Ujian_' . $exam->title . '.pdf');
    }

}