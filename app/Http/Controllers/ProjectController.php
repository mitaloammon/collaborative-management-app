<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('owner', 'members')
            ->where('owner_id', $request->user()->id)
            ->orWhereHas('members', fn($q) => $q->where('user_id', $request->user()->id))
            ->paginate(10);

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $project = Project::create([
            'owner_id' => $request->user()->id,
            ...$data,
        ]);

        $project->members()->attach($request->user()->id);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $project->load('owner', 'members', 'tasks');
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeOwner($project, $request->user()->id);

        $project->update($request->only('name', 'description', 'status', 'due_date'));
        return response()->json($project);
    }

    public function destroy(Project $project, Request $request)
    {
        $this->authorizeOwner($project, $request->user()->id);
        $project->delete();
        return response()->json(['message' => 'Projeto removido com sucesso']);
    }

    public function addMember(Project $project, Request $request)
    {
        $this->authorizeOwner($project, $request->user()->id);

        $data = $request->validate(['user_id' => 'required|exists:users,id']);
        $project->members()->syncWithoutDetaching($data['user_id']);

        return response()->json(['message' => 'Membro adicionado']);
    }

    public function removeMember(Project $project, User $user, Request $request)
    {
        $this->authorizeOwner($project, $request->user()->id);

        $project->members()->detach($user->id);
        return response()->json(['message' => 'Membro removido']);
    }

    private function authorizeOwner(Project $project, int $userId)
    {
        abort_if($project->owner_id !== $userId, 403, 'Apenas o dono pode executar esta ação.');
    }
}
