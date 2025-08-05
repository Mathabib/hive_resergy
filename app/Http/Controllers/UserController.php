<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserInvitationMail;
use Illuminate\Support\Str;


class UserController extends Controller
{

public function activeToday()
{
    $activeUsers = User::whereDate('last_login', Carbon::today())->get();

    return view('users.active_today', compact('activeUsers'));
}

    // Tampilkan daftar user
  public function index()
{
    $users = User::with('projects')->paginate(25);
    return view('users.index', compact('users'));
}


    // Form tambah user
    public function create()
    {
        $projects = Project::all(); // Untuk memilih project saat create
        return view('users.create', compact('projects'));
    }

    // Simpan user baru
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:8|confirmed',
    //         'role'     => 'nullable|string',
    //         'project_ids' => 'nullable|array',
    //     ]);

    //     $user = User::create([
    //         'name'     => $request->name,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role'     => $request->role ?? 'user',
    //     ]);

    //     // Assign project jika dipilih
    //     if ($request['role'] === 'admin') {
    //     // Admin: assign semua project
    //     $allProjects = Project::pluck('id')->toArray();
    //     $user->projects()->sync($allProjects);
    // } else {
    //     $user->projects()->sync($request['project_ids'] ?? []);
    // }
    

    //     return redirect()->route('users.index')->with('success', 'User added successfully!');
    // }



public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'nullable|string|min:8|confirmed',
        'role'     => 'nullable|string',
        'project_ids' => 'nullable|array',
    ]);

    // Jika tidak ada password dari form, generate random
    $plainPassword = $request->password ?? Str::random(10);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($plainPassword),
        'role'     => $request->role ?? 'user',
    ]);

    // Assign project
    if ($request['role'] === 'admin') {
        $allProjects = Project::pluck('id')->toArray();
        $user->projects()->sync($allProjects);
    } else {
        $user->projects()->sync($request['project_ids'] ?? []);
    }

    // Kirim Email
    Mail::to($user->email)->queue(new NewUserInvitationMail($user->name, $user->email, $plainPassword));

    return redirect()->route('users.index')->with('success', 'User added successfully!');
}




    // Form edit user
    // public function edit(User $user)
    // {
    //     $projects = Project::all();
    //     $projects_access = $user->projects;
    //     return view('users.edit', compact('user', 'projects', 'projects_access'));
    // }


public function edit($id)
{
    $user = User::with('projects')->findOrFail($id); // Ambil user sesuai ID di URL
    $projects = Project::all();
    $selectedProjects = $user->projects->pluck('id')->toArray();

    return view('users.edit', compact('user', 'projects', 'selectedProjects'));
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
    // Validasi input
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|unique:users,email,' . $user->id,
        'password'        => 'nullable|string|min:8|confirmed',
        'role'            => 'required|string|in:user,admin',
        'project_ids'     => 'nullable|array',
        'project_ids.*'   => 'exists:projects,id',
    ]);

    // Update field dasar
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->role  = $request->role;

    // Hanya update password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Simpan perubahan user
    $user->save();

    // Sync relasi project jika ada
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
