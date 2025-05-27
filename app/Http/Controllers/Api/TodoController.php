<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function create(Request $request)
    {
        $todo = $this->todoService->createTodo($request->all())->toArray();

        return response()->json($todo);
    }
}
