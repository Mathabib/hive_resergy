<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecurringTask;
use App\Models\Task;
use Carbon\Carbon;

class GenerateMonthlyTasks extends Command
{
    protected $signature = 'tasks:generate-monthly';
    protected $description = 'Generate tasks from recurring templates every month';

    public function handle()
    {
        $now = Carbon::now();
        $bulan = $now->month;
        $tahun = $now->year;

        // 1️⃣ Ambil semua recurring task aktif
        $recurringTasks = RecurringTask::all();

        // 2️⃣ Generate task baru dari template
        foreach ($recurringTasks as $template) {
            Task::create([
                'project_id' => $template->project_id,
                'nama_task' => $template->nama  .' (' . $now->translatedFormat('F Y') . ')',
                'description' => $template->deskripsi ?? '',
                'status' => 'todo',
                'priority' => 'medium',
                'progress' => 0,
                'comment' => 'Automatic tasks from routine tasks (' . $now->translatedFormat('F Y') . ')',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        \Log::info('Task bulanan dijalankan oleh scheduler.');


        $this->info("✅ Monthly tasks generated for " . $now->translatedFormat('F Y'));

    }

    // Fungsi bantu untuk identifikasi task rutinan (jika dibutuhkan)
    private function isFromRecurring(Task $task): bool
    {
        return str_contains($task->comment, 'Automatic tasks from routine tasks');
    }
}
