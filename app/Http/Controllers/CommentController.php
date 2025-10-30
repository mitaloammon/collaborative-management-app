<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        return response()->json($task->comments()->with('user')->get());
    }

    public function store(Request $request, Task $task)
    {
        $data = $request->validate(['content' => 'required|string']);

        $comment = $task->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $data['content'],
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Comment $comment, Request $request)
    {
        abort_unless($comment->user_id === $request->user()->id, 403, 'Você só pode excluir seus próprios comentários.');
        $comment->delete();
        return response()->json(['message' => 'Comentário removido']);
    }
}
