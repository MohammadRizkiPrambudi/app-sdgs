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
use Str;

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

        $assignment = Assignment::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->with('submissions.student')
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $assignment) {
            abort(404, 'Tugas tidak ditemukan.');
        }

        // Ambil semua siswa di kelas ini
        $students = Student::where('class_id', $class_id)->get();

        // Mapping submission ke student_id
        $submissionsMap = $assignment->submissions->keyBy('student_id');

        $menugrade = '';

        return view('pages.grades.show', compact('user', 'class', 'subject', 'assignment', 'students', 'submissionsMap', 'menugrade'));
    }

    public function exportPdf($assignment_id)
    {
        $assignment = Assignment::with(['class', 'subject', 'submissions.student'])->findOrFail($assignment_id);

        // Ambil semua siswa dari kelas terkait
        $students = Student::where('class_id', $assignment->class_id)->get();

        // Petakan submissions ke student_id
        $submissionsMap = $assignment->submissions->keyBy('student_id');

        // Kirim ke view PDF
        $pdf = Pdf::loadView('pages.grades.nilai_per_tugas_pdf', [
            'assignment'     => $assignment,
            'students'       => $students,
            'submissionsMap' => $submissionsMap,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Nilai_' . Str::slug($assignment->title) . '.pdf');
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