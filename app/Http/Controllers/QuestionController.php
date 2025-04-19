<?php
namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        $menuquestion = '';

        if ($user->role === 'admin') {
            $exams = Exam::with(['class', 'subject', 'questions'])->get();
        } else {
            $teacher = $user->teacher;

            $exams = Exam::whereHas('class.teachers', function ($query) use ($teacher) {
                $query->where('teachers.id', $teacher->id);
            })
                ->whereHas('subject.teachers', function ($query) use ($teacher) {
                    $query->where('teachers.id', $teacher->id);
                })
                ->with(['class', 'subject', 'questions'])
                ->get();
        }

        return view('pages.questions.index', compact('exams', 'user', 'menuquestion'));
    }

    public function create()
    {
        $user         = Auth::user();
        $menuquestion = '';

        if ($user->role === 'admin') {
            $exams = Exam::with('class', 'subject')->get();
        } else {
            $teacher = $user->teacher;

            $exams = Exam::whereHas('class.teachers', function ($query) use ($teacher) {
                $query->where('teachers.id', $teacher->id);
            })
                ->whereHas('subject.teachers', function ($query) use ($teacher) {
                    $query->where('teachers.id', $teacher->id);
                })
                ->with('class', 'subject')
                ->get();
        }

        return view('pages.questions.create', compact('user', 'exams', 'menuquestion'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'exam_id'                    => 'required|exists:exams,id',
            'questions'                  => 'required|array',
            'questions.*.question_text'  => 'required|string',
            'questions.*.option_a'       => 'required|string',
            'questions.*.option_b'       => 'required|string',
            'questions.*.option_c'       => 'required|string',
            'questions.*.option_d'       => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d',
        ]);
        $examId = $request->exam_id;
        foreach ($request->questions as $questionData) {
            Question::create([
                'exam_id'        => $examId,
                'question_text'  => $questionData['question_text'],
                'option_a'       => $questionData['option_a'],
                'option_b'       => $questionData['option_b'],
                'option_c'       => $questionData['option_c'],
                'option_d'       => $questionData['option_d'],
                'correct_option' => $questionData['correct_option'],
            ]);
        }
        Alert::success('Hore!', 'Soal Ujian Berhasil Disimpan!!');
        return redirect()->route('questions.index');
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $user = Auth::user();
        return view('pages.questions.edit', compact('question', 'user'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'option_a'       => 'required|string',
            'option_b'       => 'required|string',
            'option_c'       => 'required|string',
            'option_d'       => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
        ]);
        $question->update($request->all());
        Alert::success('Hore!', 'Soal Ujian Berhasil DiPerbarui!!');
        return redirect()->route('questions.index');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        Alert::success('Hore!', 'Soal Ujian Berhasil DiHapus!!');
        return redirect()->route('questions.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'file'    => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new QuestionsImport($request->exam_id), $request->file('file'));
            Alert::success('Hore!', 'Soal Ujian Berhasil DiImport!!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

}