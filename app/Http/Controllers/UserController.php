<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::with('projects')->get();
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $projects = Project::all(); // Untuk memilih project saat create
        return view('users.create', compact('projects'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'nullable|string',
            'project_ids' => 'nullable|array',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'user',
        ]);

        // Assign project jika dipilih
        if ($request->filled('project_ids')) {
            $user->projects()->attach($request->project_ids);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Form edit user
    public function edit(User $user)
    {
        $projects = Project::all();
        $projects_access = $user->projects;
        return view('users.edit', compact('user', 'projects', 'projects_access'));
    }

    // Beri akses ke proyek tertentu
    public function give_access(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = User::find($request->user_id);
        $user->projects()->syncWithoutDetaching([$request->project_id]);

        return redirect()->back()->with('success', 'Akses proyek berhasil diberikan.');
    }

    // Lepas akses proyek dari user
    public function detach(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->projects()->detach($request->project_id);

        return redirect()->back()->with('success', 'Akses proyek berhasil dihapus.');
    }



public function update(Request $request, User $user)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email,' . $user->id,
        'password'    => 'nullable|string|min:8|confirmed',
        'role'        => 'nullable|string',
        'project_ids' => 'nullable|array',
    ]);

    $user->name  = $request->name;
    $user->email = $request->email;
    $user->role  = $request->role ?? 'user';

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Simpan akses proyek (many-to-many sync)
    $user->projects()->sync($request->project_ids ?? []);

    return redirect()->route('users.index')->with('success', 'User has been successfully updated!');
}

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
