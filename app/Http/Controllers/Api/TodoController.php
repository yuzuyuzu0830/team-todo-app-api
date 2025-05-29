<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTodoRequest;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
        $teamId = $request->user()->team_id;
        $todos = $this->todoService->getTodosForUser($teamId);

        return response()->json($todos);
    }

    public function create(CreateTodoRequest $request)
    {
        $todo = $this->todoService->createTodo($request->validated());

        return response()->json($todo);
    }
}
