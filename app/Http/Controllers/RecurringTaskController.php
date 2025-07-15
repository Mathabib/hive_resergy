<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\RecurringTask;

use Illuminate\Http\Request;

class RecurringTaskController extends Controller
{
    public function index()
    {
        $projects = Project::with('recurringTasks')->get();
        return view('recurring_tasks.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nama' => 'required|string|max:255',
        ]);

        RecurringTask::create($request->only('project_id', 'nama', 'deskripsi'));

        return back()->with('success', 'Task rutinan ditambahkan.');
    }

    public function destroy($id)
    {
        RecurringTask::findOrFail($id)->delete();
        return back()->with('success', 'Task rutinan dihapus.');
    }
}
