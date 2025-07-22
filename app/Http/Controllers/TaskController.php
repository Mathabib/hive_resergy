<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;


class TaskController extends Controller
{
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'project_id' => 'required|exists:projects,id',
        //     'nama_task' => 'required|string|max:255',
        //     'status' => 'required|in:todo,inprogress,done',
        // ]);

        $task = Task::create([
            'project_id' => $request->project_id,
            'nama_task' => $request->nama_task,
            'status' => $request->status,
            'description' => $request->description
        ]);

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

    public function show(Task $task)
    {
        $task->load('assignToUser', 'comments.user', 'project');
        $estimate = 0;
        if($task->start_date != null && $task->end_date != null){
            $estimate = Carbon::parse($task->end_date)->diffInDays(Carbon::parse($task->start_date)) + 1;            
        }        
        return view('tasks.show', compact('task', 'estimate'));
    }

    public function estimate(Task $task)
    {
         $estimate = Carbon::parse($task->end_date)->diffInDays(Carbon::parse($task->start_date)) + 1;
        return $estimate;
    }


//  public function update(Request $request, Task $task)
// {
//     $request->validate([
//         'nama_task' => 'nullable|string|max:255',
//         'status' => 'nullable|in:todo,inprogress,done',
//         'start_date' => 'nullable|date',
//         'end_date' => 'nullable|date|after_or_equal:start_date',
//         'estimate' => 'nullable',
//         'assign_to' => 'nullable|exists:users,id',
//         'priority' => 'nullable|in:low,medium,high',
//         'description' => 'nullable',
//         'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
//     ]);

//     $data = [];

//     if ($request->filled('nama_task')) $data['nama_task'] = $request->nama_task;
//     if ($request->filled('status')) $data['status'] = $request->status;
//     if ($request->filled('start_date')) $data['start_date'] = $request->start_date;
//     if ($request->filled('end_date')) $data['end_date'] = $request->end_date;
//     if ($request->filled('estimate')) $data['estimate'] = $request->estimate;
//     if ($request->filled('assign_to')) $data['assign_to'] = $request->assign_to;
//     if ($request->filled('priority')) $data['priority'] = $request->priority;
//     if ($request->filled('description')) $data['description'] = $request->description;

//     if (!empty($data)) {
//         $task->update($data);
//     }

//     $newAttachments = collect();

//     if ($request->hasFile('attachment')) {
//         foreach ($request->file('attachment') as $file) {
//             $file->storeAs('attachments', $file->getClientOriginalName(), 'public');

//             $task->attachments()->create([
//                 'filename' => $file->getClientOriginalName(),
//             ]);
//         }
//     }

//     // Load ulang attachments supaya yang baru juga ikut
//     $task->load('attachments');

//     // Return JSON dengan attachments terbaru
//     return response()->json([
//         'attachments' => $task->attachments,
//     ]);
// }


public function update(Request $request, Task $task)
{
    // ✅ Validasi input
    $request->validate([
        'nama_task'    => 'nullable|string|max:255',
        'status'       => 'nullable|in:todo,inprogress,done',
        'start_date'   => 'nullable|date',
        'end_date'     => 'nullable|date|after_or_equal:start_date',
        'assign_to'    => 'nullable|exists:users,id',
        'priority'     => 'nullable|in:low,medium,high',
        'description'  => 'nullable|string',
        'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    $data = [];

    // ✅ Masukkan field yang ada ke array $data
    if ($request->filled('nama_task'))   $data['nama_task']   = $request->nama_task;
    if ($request->filled('status'))      $data['status']      = $request->status;
    if ($request->filled('start_date'))  $data['start_date']  = $request->start_date;
    if ($request->filled('end_date'))    $data['end_date']    = $request->end_date;
    if ($request->filled('assign_to'))   $data['assign_to']   = $request->assign_to;
    if ($request->filled('priority'))    $data['priority']    = $request->priority;
    if ($request->filled('description')) $data['description'] = $request->description;

    // ✅ Hitung estimate kalau ada start_date & end_date
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $start = \Carbon\Carbon::parse($request->start_date);
        $end   = \Carbon\Carbon::parse($request->end_date);

        $estimate = $start->diffInDays($end) + 1; // +1 untuk include hari awal & akhir
        $data['estimate'] = $estimate;
    }

    // ✅ Update task hanya kalau ada perubahan
    if (!empty($data)) {
        $task->update($data);
    }

    // ✅ Handle file attachment
    if ($request->hasFile('attachment')) {
        foreach ($request->file('attachment') as $file) {
            // Simpan file ke storage/app/public/attachments
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments', $filename, 'public');

            // Simpan record ke DB
            $task->attachments()->create([
                'filename' => $filename,
            ]);
        }
    }

    // ✅ Load ulang relasi attachments
    $task->load('attachments');

   return response()->json([
    'message'     => 'Task berhasil diperbarui.',
    'task'        => $task,
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
