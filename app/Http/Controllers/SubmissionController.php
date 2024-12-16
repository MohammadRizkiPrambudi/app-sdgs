<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SubmissionController extends Controller
{
    public function create(Assignment $assignment)
    {
        $user = Auth::user();
        return view('pages.submission.create', compact('assignment', 'user'));
    }
    public function store(Request $request, Assignment $assignment)
    {
        try {
            $request->validate(['file' => 'required|file|mimes:pdf,doc,docx,zip']);
            $filePath = $request->file('file')->store('submissions');
            Submission::create([
                'assignment_id' => $assignment->id,
                'student_id' => Auth::user()->student->id,
                'file_path' => $filePath]);
            Alert::success('Hore', 'Tugasmu Berhasil Diunggah');
            return redirect()->route('student.dashboard');
        } catch (\Exception $e) {
            Alert::error('Uppps', 'Unggah Tugas Gagal!!');
            return redirect()->back();
        }
    }
    public function grade(Request $request, Submission $submission)
    {
        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
        ]);
        $submission->update(['grade' => $request->grade]);
        return redirect()->route('assignments.index')->with('success', 'Nilai berhasil diperbarui');
    }
    public function download(Submission $submission)
    {
        return Storage::download($submission->file_path);
    }

}