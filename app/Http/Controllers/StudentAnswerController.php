<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentAnswerController extends Controller
{
    public function index()
    {
        $studentAnswers = StudentAnswer::all();
        return view('student_answers.index', compact('studentAnswers'));
    }
    public function create()
    {
        return view('student_answers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'exam_id' => 'required',
            'question_id' => 'required',
            'answer' => 'required',
            'is_correct' => 'required',
        ]);
        StudentAnswer::create($request->all());
        return redirect()->route('student_answers.index');
    }

    public function show(StudentAnswer $studentAnswer)
    {
        return view('student_answers.show', compact('studentAnswer'));
    }

    public function edit(StudentAnswer $studentAnswer)
    {
        return view('student_answers.edit', compact('studentAnswer'));
    }

    public function update(Request $request, StudentAnswer $studentAnswer)
    {
        $request->validate([
            'student_id' => 'required',
            'exam_id' => 'required',
            'question_id' => 'required',
            'answer' => 'required',
            'is_correct' => 'required',
        ]);
        $studentAnswer->update($request->all());
        return redirect()->route('student_answers.index');
    }

    public function destroy(StudentAnswer $studentAnswer)
    {
        $studentAnswer->delete();
        return redirect()->route('student_answers.index');
    }
}