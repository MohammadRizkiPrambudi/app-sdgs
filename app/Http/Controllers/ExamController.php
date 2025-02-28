<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $exams = Exam::all();
        $menuujian = '';
        return view('pages.exam.index', compact('exams', 'user', 'menuujian'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'token' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        Exam::create($request->all());
        return redirect()->route('exams.index');
    }

    public function show(Exam $exam)
    {
        return view('exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'token' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $exam->update($request->all());
        return redirect()->route('exams.index');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index');
    }

}