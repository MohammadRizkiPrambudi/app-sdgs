<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teachers = Teacher::all();
        $menuteacher = 'active';
        $title = 'Hapus Data Guru!';
        $text = "Aapakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.teacher.index', compact('teachers', 'menuteacher', 'user'));
    }
    public function create()
    {
        $user = Auth::user();
        $menuteacher = 'active';
        return view('pages.teacher.create', compact('menuteacher', 'user'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'guru',
        ]);

        Teacher::create([
            'name' => $request->input('name'),
            'user_id' => $user->id,
        ]);

        Alert::success('Hore!', 'Guru Berhasil Ditambahkan');
        return redirect()->route('teachers.index');
    }

    public function edit(Teacher $teacher)
    {
        $user = Auth::user();
        $menuteacher = 'active';
        return view('pages.teacher.edit', compact('teacher', 'menuteacher', 'user'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->name = $request->input('name');
        $teacher->save();

        $user = $teacher->user;
        $user->name = $request->input('name');
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

}