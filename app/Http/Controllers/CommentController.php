<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentAddedMail;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
class CommentController extends Controller
{

      public function index(Task $task)
    {
        // $task = Task::find($id);
        // $comments =  $task->comments()->get();
        // $comments = $task->comments()->with('user')->latest()->get();
        $comments = $task->comments()->with('user')->get();
        // return response()->json($comments);
        return $comments;
    }


    // public function store(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'comment' => 'required|string|max:1000',
    //     ]);

    //     $comment = $task->comments()->create([
    //         // 'user_id' => auth()->id(),
    //         'user_id' => $request->user_id,
    //         'content' => $request->comment,
    //     ]);

    //     $comment->load('user');

    //     return response()->json($comment);
    // }




public function store(Request $request, Task $task)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
        'user_id' => 'required|exists:users,id',
    ]);

    $comment = $task->comments()->create([
        'user_id' => $request->user_id,
        'content' => $request->comment,
    ]);

    $comment->load('user');

    Log::info("Komentar baru dari user: {$comment->user->name} pada task ID {$task->id}");

    $projectUsers = $task->project->users;

    foreach ($projectUsers as $user) {
        if ($user->id !== $comment->user_id && $user->email) {
            Mail::to($user->email)->queue(new CommentAddedMail($comment, $task));
            Log::info("Email dikirim ke: {$user->email}");
        }
    }

    return response()->json($comment);
}







}
