<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->middleware('auth:sanctum');
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $todos = $this->todoService->getTodosForUser($userId);

        return response()->json($todos);
    }
}
