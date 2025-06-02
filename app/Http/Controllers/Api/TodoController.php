<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTodoRequest;
use App\Services\TodoService;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(User $user)
    {
        $todos = $this->todoService->getTodosForUser($user->team_id);

        return response()->json(['todos' => $todos]);
    }

    public function create(CreateTodoRequest $request)
    {
        $todo = $this->todoService->createTodo($request->validated());

        return response()->json($todo);
    }
}
