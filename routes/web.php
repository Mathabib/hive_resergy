<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\RecurringTaskController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Artisan; 
use App\Http\Controllers\Auth\PasswordResetLinkController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });



Route::get('/dashboard', [ProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/gantt', function () {
    $tasks = [
        [
            'id' => 'Task1',
            'name' => 'Perencanaan',
            'start' => '2025-06-01',
            'end' => '2025-06-05',
            'progress' => 20,
        ],
        [
            'id' => 'Task2',
            'name' => 'Pengembangan',
            'start' => '2025-06-06',
            'end' => '2025-06-15',
            'progress' => 10,
            'dependencies' => 'Task1'
        ],
    ];

    return view('projects.gantt', compact('tasks'));
});

Route::middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index2'])->name('projects.index2');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    Route::get('users/activeToday', [UserController::class, 'activeToday'])->name('users.activeToday');
    Route::resource('users', UserController::class);
  

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects_list/{project}', [ProjectController::class, 'list'])->name('projects.list');
    Route::get('/projects/{project}/gantt', [ProjectController::class, 'gantt'])->name('projects.gantt');
    Route::post('/gantt/update', [App\Http\Controllers\ProjectController::class, 'updateTaskDates'])->name('gantt.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/project/give_access', [UserController::class, 'give_access'])->name('projects.give_access');
    Route::post('/project/detach', [UserController::class, 'detach'])->name('projects.detach');

    Route::get('/task-rutinan', [RecurringTaskController::class, 'index'])->name('admin.task-rutinan');
    Route::post('/task-rutinan', [RecurringTaskController::class, 'store'])->name('admin.task-rutinan.store');
    Route::get('/task-rutinan/{id}/edit', [RecurringTaskController::class, 'edit'])->name('admin.task-rutinan.s.edit');
    Route::put('/task-rutinan/{id}', [RecurringTaskController::class, 'update'])->name('admin.task-rutinan.s.update');
    Route::delete('/task-rutinan/{id}', [RecurringTaskController::class, 'destroy'])->name('admin.task-rutinan.destroy');

   Route::get('/theme-settings', [ThemeController::class, 'index'])->name('theme.index');

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/task/delete/{project}/{task}', [TaskController::class, 'delete'])->name('task.delete');
Route::post('/tasks/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::delete('/attachments/{attachment}', [TaskController::class, 'destroyAttachment'])
    ->name('attachments.destroy');


// Simpan pengaturan tema (POST / AJAX)
Route::post('/theme-settings/update', [ThemeController::class, 'update'])->name('theme.update');

    Route::post('/task-rutinan/generate-now', function () {
    Artisan::call('tasks:generate-monthly');
    return back()->with('success', 'Routine tasks successfully generated for this month.');
})->name('admin.task-rutinan.generate-now');
    



// Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//     ->middleware('guest')
//     ->name('password.request');

// Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//     ->middleware('guest')
//     ->name('password.email');


// web.php
Route::post('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::middleware('auth')->post('/tasks/{task}/comments', [CommentController::class, 'store']);
});

require __DIR__.'/auth.php';
