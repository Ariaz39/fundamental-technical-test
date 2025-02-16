<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Services\TaskService;

class TaskController extends Controller
{
    private const TASK_NOT_FOUND_RESPONSE = ['error' => 'Tarea no encontrada'];

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->listTasksForUser(auth()->id());
        return response()
            ->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTaskForUser(auth()->id(), $request->validated());
        return response()
            ->json($task, 201);
    }

    public function show($id)
    {
        $task = $this->taskService->getTaskByIdForUser($id, auth()->id());

        if (!$task) {
            return response()
                ->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()
            ->json($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->updateTaskForUser($id, auth()->id(), $request->validated());

        if (!$task) {
            return response()
                ->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()
            ->json($task);
    }

    public function destroy($id)
    {
        $deleted = $this->taskService->deleteTaskForUser($id, auth()->id());

        if (!$deleted) {
            return response()
                ->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()
            ->json(['message' => 'Task deleted successfully']);
    }
}
