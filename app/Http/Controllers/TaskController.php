<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Mail;


class TaskController extends Controller
{

public function myAssignedTasks()
{
    $user = Auth::user();

    $tasks = Task::whereHas('assignedUsers', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->latest()->paginate(25);

    // Kirim variabel projects jika memang dibutuhkan oleh view
    $projects = Project::all(); // atau sesuai kebutuhan

    return view('tasks.index', compact('tasks', 'projects'));
}


public function index()
{
    $query = Task::with('project', 'assignToUser');

    // Filter pencarian
    if (request('search')) {
        $query->where('nama_task', 'like', '%' . request('search') . '%');
    }

    // Filter status
    if (request('status')) {
        $query->where('status', request('status'));
    }

    // Filter project
    if (request('project_id')) {
        $query->where('project_id', request('project_id'));
    }

    // Pagination
    $tasks = $query->paginate(25)->withQueryString();

    // Kirim semua project untuk dropdown
    $projects = \App\Models\Project::all();

    return view('tasks.index', compact('tasks', 'projects'));
}






   public function store(Request $request)
{
    // Validasi input (aktifkan jika perlu)
    // $validated = $request->validate([
    //     'project_id' => 'required|exists:projects,id',
    //     'nama_task' => 'required|string|max:255',
    //     'status' => 'required|in:todo,inprogress,done',
    //     'assigned_user_ids' => 'array' // misalnya kamu kirim array user ID
    // ]);

    // Simpan task baru
    $task = Task::create([
        'project_id' => $request->project_id,
        'nama_task'  => $request->nama_task,
        'status'     => $request->status,
        'description'=> $request->description,
    ]);

    // Assign user ke task (jika ada)
    if ($request->has('assigned_user_ids')) {
        foreach ($request->assigned_user_ids as $userId) {
            $task->assignedUsers()->attach($userId, ['is_read' => false]);
        }
    }

    return response()->json(['task' => $task], 201);
}


    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:todo,inprogress,done',
        ]);

        $task = Task::findOrFail($validated['task_id']);
        $task->status = $validated['status'];
        $task->save();

        return response()->json(['success' => true]);
    }

    public function delete(Project $project, Task $task){
        // return $project;
        $task->delete();
        return redirect(route('projects.show', $project->id));
    }

    // public function show(Task $task)
    // {
    //     $task->load('assignToUser', 'comments.user', 'project');
    //     $estimate = 0;
    //     if($task->start_date != null && $task->end_date != null){
    //         $estimate = Carbon::parse($task->end_date)->diffInDays(Carbon::parse($task->start_date)) + 1;            
    //     }        
    //     return view('tasks.show', compact('task', 'estimate'));
    // }



public function show(Task $task)
{
    // Load relasi assignedUsers agar bisa akses pivot (is_read)
    $task->load('assignedUsers', 'comments.user', 'project');

    // Cek apakah user yang sedang login termasuk yang di-assign
    if ($task->assignedUsers->contains(Auth::id())) {
        // Tandai sebagai sudah dibaca di pivot
        $task->assignedUsers()->updateExistingPivot(Auth::id(), [
            'is_read' => true
        ]);
    }

    // Hitung estimasi durasi (dalam hari)
    $estimate = 0;
    if ($task->start_date && $task->end_date) {
        $estimate = Carbon::parse($task->end_date)->diffInDays(Carbon::parse($task->start_date)) + 1;
    }

    return view('tasks.show', compact('task', 'estimate'));
}


    public function estimate(Task $task)
    {
         $estimate = Carbon::parse($task->end_date)->diffInDays(Carbon::parse($task->start_date)) + 1;
        return $estimate;
    }



public function update(Request $request, Task $task)
{
    // Validasi input
    $request->validate([
        'nama_task'    => 'nullable|string|max:255',
        'status'       => 'nullable|in:todo,inprogress,done',
        'start_date'   => 'nullable|date',
        'end_date'     => 'nullable|date|after_or_equal:start_date',
        'assign_to'    => 'nullable|array',
        'assign_to.*'  => 'exists:users,id',
        'priority'     => 'nullable|in:low,medium,high',
        'description'  => 'nullable|string',
        'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    $data = [];

    // Masukkan field yang ada ke array $data
    if ($request->filled('nama_task'))    $data['nama_task']   = $request->nama_task;
    if ($request->filled('status'))       $data['status']      = $request->status;
    if ($request->filled('start_date'))   $data['start_date']  = $request->start_date;
    if ($request->filled('end_date'))     $data['end_date']    = $request->end_date;
    if ($request->filled('priority'))     $data['priority']    = $request->priority;
    if ($request->filled('description'))  $data['description'] = $request->description;

    // Hitung estimate kalau ada start_date & end_date
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $start = \Carbon\Carbon::parse($request->start_date);
        $end   = \Carbon\Carbon::parse($request->end_date);
        $data['estimate'] = $start->diffInDays($end) + 1; // +1 untuk include hari awal & akhir
    }

    // Update task hanya kalau ada perubahan
    if (!empty($data)) {
        $task->update($data);
    }

    // // Update assign_to (pivot table many-to-many)
    // if ($request->has('assign_to')) {
    //     $task->assignedUsers()->sync($request->assign_to); // replace previous assignments
    // }

    if ($request->has('assign_to')) {
    // Ambil user ID sebelum update
    $oldUserIds = $task->assignedUsers()->pluck('users.id')->toArray();

    // Sync assignment baru
    $task->assignedUsers()->sync($request->assign_to);

    // Ambil user baru yang belum pernah di-assign sebelumnya
    $newAssignedUsers = \App\Models\User::whereIn('id', $request->assign_to)
        ->whereNotIn('id', $oldUserIds)
        ->get();

    // Kirim email ke user baru
    foreach ($newAssignedUsers as $user) {
        try {
            Mail::to($user->email)->queue(new TaskAssignedMail($task));
             Log::info("Email dikirim ke: {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Gagal kirim email ke {$user->email}: " . $e->getMessage());
        }
    }
}

    // Handle file attachment
    if ($request->hasFile('attachment')) {
        foreach ($request->file('attachment') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments', $filename, 'public');

            $task->attachments()->create([
                'filename' => $filename,
            ]);
        }
    }

    // Load ulang relasi attachments
    $task->load('attachments', 'assignedUsers');

    return response()->json([
        'message'     => 'Task berhasil diperbarui.',
        'task'        => $task,
        'assign_to'   => $task->assignedUsers->pluck('name'),
        'attachments' => $task->attachments->map(function ($file) {
            return [
                'id'          => $file->id,
                'filename'    => $file->filename,
                'delete_url'  => route('attachments.destroy', $file->id),
            ];
        }),
    ]);
}




public function destroyAttachment(Attachment $attachment)
{
    // Path yang sesuai dengan Laravel storage
    $filePath = 'attachments/' . $attachment->filename;

    if (Storage::disk('public')->exists($filePath)) {
        Storage::disk('public')->delete($filePath); // hapus file di storage
    }

    $attachment->delete(); // hapus database

    return response()->json(['message' => 'Attachment deleted successfully.']);
}


}
