<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class ProjectController extends Controller
{
    // public function index()
    // {
    //     if(Auth::user()->role == 'admin'){
    //         $projects_sidebar = Project::all();
    //     } else{
    //         $projects_sidebar = Auth::user()->projects;
    //     }
    //     return view('dashboard', compact('projects_sidebar'));
    // }

public function index()
{
    if (Auth::user()->role == 'admin') {
        // ✅ Data untuk admin
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $totalUsers = \App\Models\User::count();

        $activeUsersToday = \App\Models\User::whereDate('last_login', Carbon::today())->count();

        $tasksPerProject = Project::withCount('tasks')->get();

        // ✅ Hitung task per status (ADMIN: semua project)
        $todoTasks = Task::where('status', 'todo')->count();
        $inprogressTasks = Task::where('status', 'inprogress')->count();
        $doneTasks = Task::where('status', 'done')->count();

        // 📊 Hitung jumlah task per bulan untuk setiap status
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('M');
        });

        $todoTasksPerMonth = [];
        $inprogressTasksPerMonth = [];
        $doneTasksPerMonth = [];

        foreach (range(1, 12) as $month) {
            $todoTasksPerMonth[] = Task::where('status', 'todo')
                ->whereMonth('created_at', $month)
                ->count();

            $inprogressTasksPerMonth[] = Task::where('status', 'inprogress')
                ->whereMonth('created_at', $month)
                ->count();

            $doneTasksPerMonth[] = Task::where('status', 'done')
                ->whereMonth('created_at', $month)
                ->count();
        }

        // ✅ Task summary untuk admin
        $taskStats = [
            'completed'   => $doneTasks,
            'in_progress' => $inprogressTasks,
            'pending'     => $todoTasks,
        ];

        return view('dashboard', compact(
            'totalProjects',
            'totalTasks',
            'totalUsers',
            'activeUsersToday',
            'tasksPerProject',
            'months',
            'todoTasksPerMonth',
            'inprogressTasksPerMonth',
            'doneTasksPerMonth',
            'todoTasks',
            'inprogressTasks',
            'doneTasks',
            'taskStats'
        ));
    } else {
        // ✅ Data untuk user
        $projects_sidebar = Auth::user()->projects; // ambil project yang user punya akses
        $projectIds = $projects_sidebar->pluck('id'); // ambil semua ID project user

        // ✅ Hitung task di semua project user
        $todoTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', 'todo')
            ->count();

        $inprogressTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', 'inprogress')
            ->count();

        $doneTasks = Task::whereIn('project_id', $projectIds)
            ->where('status', 'done')
            ->count();

        $totalTasks = Task::whereIn('project_id', $projectIds)->count();

        // 📊 Hitung jumlah task per bulan untuk user (hanya task di project yang user akses)
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('M');
        });

        $todoTasksPerMonth = [];
        $inprogressTasksPerMonth = [];
        $doneTasksPerMonth = [];

        foreach (range(1, 12) as $month) {
            $todoTasksPerMonth[] = Task::whereIn('project_id', $projectIds)
                ->where('status', 'todo')
                ->whereMonth('created_at', $month)
                ->count();

            $inprogressTasksPerMonth[] = Task::whereIn('project_id', $projectIds)
                ->where('status', 'inprogress')
                ->whereMonth('created_at', $month)
                ->count();

            $doneTasksPerMonth[] = Task::whereIn('project_id', $projectIds)
                ->where('status', 'done')
                ->whereMonth('created_at', $month)
                ->count();
        }

        return view('dashboard', compact(
            'projects_sidebar',
            'todoTasks',
            'inprogressTasks',
            'doneTasks',
            'totalTasks',
            'months',
            'todoTasksPerMonth',
            'inprogressTasksPerMonth',
            'doneTasksPerMonth'
        ));
    }
}






public function show(Project $project)
{
    // Ambil semua task project
    $tasks = $project->tasks()->get();
    
    return view('projects.show', compact('project', 'tasks'));
}

public function list(Project $project)
{
    $tasks = $project->tasks()
                     ->with('assignToUser') // <-- bagian ini kita set relasi user
                     ->paginate(25);
    return view('projects.list', compact('project', 'tasks'));
}


public function index2()
{
       // Ambil semua project root (tanpa parent)
    $projects = Project::with('children')->whereNull('parent_id')->get();
    $projects = Project::all();
    return view('projects.index', compact('projects'));
}

public function create()
{
    return view('projects.create');
}


    // Simpan data project baru ke database
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validated = $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'deskripsi' => 'nullable|string',
    //     ]);

    //     Project::create([
    //         'nama' => $validated['nama'],
    //         'deskripsi' => $validated['deskripsi'] ?? '',
    //     ]);

    //     return redirect()->route('projects.index2') // sesuaikan dengan route index-mu
    //                      ->with('success', 'Project added successfully!');
    // }

    public function store(Request $request)
{
    // Validasi input termasuk parent_id
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'parent_id' => 'nullable|exists:projects,id', // tambahkan ini
    ]);

    // Simpan project
    Project::create([
        'nama' => $validated['nama'],
        'deskripsi' => $validated['deskripsi'] ?? '',
        'parent_id' => $validated['parent_id'] ?? null, // simpan parent_id
    ]);

    return redirect()->route('projects.index2')
                     ->with('success', 'Project added successfully!');
}



      // Tampilkan form edit project
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    // Update data project di database
    public function update(Request $request, Project $project)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $project->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? '',
        ]);

        return redirect()->route('projects.index2') // sesuaikan dengan route index-mu
                         ->with('success', 'Profile updated successfully!');
    }

    // Hapus project (kalau perlu)
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index2')
                         ->with('success', 'Project deleted successfully!');
    }

    public function gantt(Project $project)
    {
        $tasks = $project->tasks()
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get();

        $ganttTasks = $tasks->map(function($task) {
            return [
                'id' => (string) $task->id,
                'name' => $task->nama_task,
                'start' => date('Y-m-d', strtotime($task->start_date)), 
                'end' => date('Y-m-d', strtotime($task->end_date)),
                'progress' => match ($task->status) {
                    'todo' => 0,
                    'inprogress' => 50,
                    'done' => 100,
                    default => 0
                },
                'custom_class' => 'ganti_warna',
                'color' => '#ffc909'
            ];
        });

        return view('projects.gantt', compact('project', 'ganttTasks'));
    }


public function updateTaskDates(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer|exists:tasks,id',
        'start' => 'required|date',
        'end' => 'required|date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }

    $task = Task::find($request->id);
    $task->start_date = $request->start;
    $task->end_date = $request->end;
    $task->save();

    return response()->json([
        'message' => 'Task berhasil diperbarui.',
        'task' => $task,
    ]);
}






}
