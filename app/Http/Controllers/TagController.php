<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        return response()->json(Tag::create($data), 201);
    }

    public function attachToTask(Task $task, Tag $tag)
    {
        $task->tags()->syncWithoutDetaching($tag->id);
        return response()->json(['message' => 'Etiqueta associada à tarefa']);
    }

    public function detachFromTask(Task $task, Tag $tag)
    {
        $task->tags()->detach($tag->id);
        return response()->json(['message' => 'Etiqueta removida da tarefa']);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'Tag excluída']);
    }
}

