<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    private const TASK_NOT_FOUND_RESPONSE = ['error' => 'Tarea no encontrada'];

    protected TaskService $taskService;

    /**
     * Constructor del TaskController.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Lista todas las tareas del usuario autenticado, paginadas.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->listTasksForUser(auth()->id());
        return response()->json($tasks);
    }

    /**
     * Crea una nueva tarea asociada al usuario autenticado.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTaskForUser(auth()->id(), $request->validated());
        return response()->json($task, 201);
    }

    /**
     * Muestra la información detallada de una tarea específica del usuario autenticado.
     *
     * @param int $id ID de la tarea.
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskByIdForUser($id, auth()->id());

        if (!$task) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()->json($task);
    }

    /**
     * Actualiza una tarea existente del usuario autenticado.
     *
     * @param UpdateTaskRequest $request
     * @param int $id ID de la tarea.
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $task = $this->taskService->updateTaskForUser($id, auth()->id(), $request->validated());

        if (!$task) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()->json($task);
    }

    /**
     * Elimina una tarea del usuario autenticado.
     *
     * @param int $id ID de la tarea.
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->taskService->deleteTaskForUser($id, auth()->id());

        if (!$deleted) {
            return response()->json(self::TASK_NOT_FOUND_RESPONSE, 404);
        }

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
