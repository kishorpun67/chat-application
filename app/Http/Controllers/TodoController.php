<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Services\TodoService;
class TodoController extends Controller
{
    public $todoService;
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index()
    {
        $todos = $this->todoService->getTodos();
        return view('todos.index', ['todos'=>$todos] );
    }

    public function create(PostRequest $postRequest)
    {
        $this->todoService->createTodo($postRequest);
        return to_route('todos');
    }
}
