<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Tambahkan command custom di sini
// use App\Console\Commands\GenerateMonthlyTasks;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected $commands = [
        // GenerateMonthlyTasks::class, // <-- pastikan ini ditambahkan
    ];

    /**
     * Define the application's command schedule.
     */
protected function schedule(Schedule $schedule)
{
    $schedule->command('tasks:generate-monthly')->monthlyOn(1, '00:00');
    // $schedule->command('tasks:generate-monthly')->everyMinute();
}

    /**
     * Register the commands for Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
