<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Exam;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ExamController extends Controller
{
    public function index()
    {
        // $user     = Auth::user();
        // $menuexam = '';
        // $classes  = Classes::all();
        // $subjects = Subject::all();
        // $exams    = Exam::with(['class', 'subject'])->get();
        // $title    = 'Hapus Ujian!';
        // $text     = "Apakah anda yakin akan menghapus?";
        // confirmDelete($title, $text);
        // return view('pages.exam.index', compact('exams', 'user', 'menuexam', 'classes', 'subjects'));

        $user     = Auth::user();
        $menuexam = '';
        $title    = 'Hapus Ujian!';
        $text     = "Apakah anda yakin akan menghapus?";
        confirmDelete($title, $text);

        if ($user->role === 'admin') {
            $classes  = Classes::all();
            $subjects = Subject::all();
            $exams    = Exam::with(['class', 'subject'])->get();
        } else {
            $teacher  = $user->teacher;
            $classes  = $teacher->classes;  // relasi dari class_teacher
            $subjects = $teacher->subjects; // relasi ke subject
            $exams    = Exam::with(['class', 'subject'])
                ->whereIn('class_id', $classes->pluck('id'))
                ->whereIn('subject_id', $subjects->pluck('id'))
                ->get();
        }

        return view('pages.exam.index', compact('exams', 'user', 'menuexam', 'classes', 'subjects'));

    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title'       => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'class_id'    => 'required|exists:classes,id',
    //         'subject_id'  => 'required|exists:subjects,id',
    //         'start_time'  => 'required|date',
    //         'end_time'    => 'required|date|after:start_time',
    //     ]);
    //     $subject     = Subject::find($request->subject_id);
    //     $currentDate = now()->format('Ymd');
    //     $token       = strtoupper(substr($subject->name, 0, 3)) . '_' . $currentDate;
    //     $request->merge(['token' => $token]);
    //     Exam::create($request->all());
    //     Alert::success('Hore!', 'Ujian Berhasil Ditambahkan');
    //     return redirect()->route('exams.index');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'  => 'required|exists:subjects,id',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
        ]);

        $user = Auth::user();

        // Kalau guru, cek apakah dia memang mengajar mapel tersebut di kelas tersebut
        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            $isValid = $teacher->classes()->where('class_id', $request->class_id)->exists() &&
            $teacher->subjects()->where('subject_id', $request->subject_id)->exists();

            if (! $isValid) {
                return redirect()->back()->with('error', 'Anda tidak berhak membuat ujian untuk kelas/mapel ini.');
            }
        }

        // Generate token
        $subject     = Subject::find($request->subject_id);
        $currentDate = now()->format('Ymd');
        $token       = strtoupper(substr($subject->name, 0, 3)) . '_' . $currentDate;
        $request->merge(['token' => $token]);

        Exam::create($request->all());
        Alert::success('Hore!', 'Ujian Berhasil Ditambahkan');
        return redirect()->route('exams.index');
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'  => 'required|exists:subjects,id',
            'token'       => 'required|string|max:255',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
        ]);
        $exam->update($request->all());
        Alert::success('Hore!', 'Ujian Berhasil DiPerbarui');
        return redirect()->route('exams.index');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index');
    }

    public function examStudents()
    {
        $menuexam       = '';
        $user           = Auth::user();
        $studentClassId = $user->student->class_id;
        $exams          = Exam::where('class_id', $studentClassId)->get();
        foreach ($exams as $exam) {
            $exam->is_completed = StudentAnswer::where('student_id', $user->student->id)
                ->where('exam_id', $exam->id)
                ->exists();
        }
        return view('pages.exam.examstudent', compact('exams', 'menuexam', 'user'));
    }

    public function examStudentStart(Request $request, Exam $exam)
    {
        $user     = Auth::user();
        $menuexam = '';
        if ($request->token !== $exam->token) {
            Alert::error('Uppss!', 'Token tidak valid!!');
            return redirect()->back();
        }
        $now       = now();
        $startTime = Carbon::parse($exam->start_time);
        $endTime   = Carbon::parse($exam->end_time);
        if ($now < $exam->start_time) {
            return redirect()->back()->with('error', 'Ujian belum dimulai.');
        }
        if ($now > $exam->end_time) {
            return redirect()->back()->with('error', 'Ujian sudah berakhir.');
        }
        $remainingTime = $endTime->diffInSeconds($now);
        session(['exam_start_time' => $now]);
        // $questions = $exam->questions;
        $questions = $exam->questions->shuffle();
        return view('pages.exam.startexamstudent', compact('exam', 'questions', 'user', 'menuexam', 'remainingTime'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $user      = Auth::user();
        $studentId = $user->student->id;
        $answers   = $request->answers;

        foreach ($answers as $answer) {
            $question  = Question::find($answer['question_id']);
            $isCorrect = $answer['answer'] === $question->correct_option;
            StudentAnswer::create([
                'student_id'  => $studentId,
                'exam_id'     => $exam->id,
                'question_id' => $answer['question_id'],
                'answer'      => $answer['answer'],
                'is_correct'  => $isCorrect,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function result(Exam $exam)
    {
        $user      = Auth::user();
        $studentId = Auth::user()->student->id;
        $menuexam  = '';
        $answers   = StudentAnswer::where('student_id', $studentId)
            ->whereIn('question_id', $exam->questions->pluck('id'))
            ->get();

        $totalQuestions = $exam->questions->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $score          = round(($correctAnswers / $totalQuestions) * 100, 1);

        return view('pages.exam.examresult', compact('exam', 'menuexam', 'score', 'correctAnswers', 'totalQuestions', 'user'));
    }
}