<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menuadmin = 'active';
        $users = User::where('role', 'admin')->get();
        $title = 'Hapus Admin!';
        $text = "Aapakah anda yakin akan menghapus?";
        confirmDelete($title, $text);
        return view('pages.user.index', compact('users', 'user', 'menuadmin'));
    }

    public function create()
    {
        $user = Auth::user();
        $menuadmin = 'active';
        return view('pages.user.create', compact('user', 'menuadmin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Alert::success('Hore!', 'Admin Berhasil Ditambahkan');
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        $menuadmin = 'active';
        return view('pages.user.edit', compact('user', 'user', 'menuadmin'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        Alert::success('Hore!', 'Admin Berhasil Diperbarui');
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

}