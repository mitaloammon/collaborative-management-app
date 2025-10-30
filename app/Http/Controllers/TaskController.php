<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->with('assignee', 'tags')->paginate(10);
        return response()->json($tasks);
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        // regra: só membros podem criar
        abort_unless($project->members->contains($request->user()->id), 403, 'Você não pertence a este projeto.');

        $task = $project->tasks()->create($data);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $task->load('project', 'assignee', 'comments.user', 'tags');
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|string|max:150',
            'status' => 'in:open,in_progress,done',
            'priority' => 'in:low,medium,high',
        ]);

        $task->update($request->only('title', 'description', 'status', 'priority', 'due_date'));
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Tarefa excluída']);
    }
}
