<?php

namespace App\Services;

use App\Interfaces\TodoInterface;

class TodoService
{
    public $todoInterface;
    /**
     * Create a new class instance.
     */
    public function __construct(TodoInterface $todoInterface)
    {
        $this->todoInterface = $todoInterface;
    }

    public function getTodos()
    {
        return $this->todoInterface->getTodos();
    }
 
    public function createTodo($request)
    {

        $data = $this->mapTodoFormData($request);
        return $this->todoInterface->createTodo($data);
    }


    public function mapTodoFormData($request)
    {
        return [
            'title' => $request['title'],
            'description' => $request['description'],
        ];
    }
}
