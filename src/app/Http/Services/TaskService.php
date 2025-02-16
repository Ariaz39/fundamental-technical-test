<?php

namespace App\Http\Services;

use App\Models\Task;
use App\Http\Repositories\TaskRepository;

class TaskService
{
    protected TaskRepository $taskRepository;

    /**
     * Constructor del servicio de tareas.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Lista todas las tareas pertenecientes a un usuario.
     *
     * @param int $userId ID del usuario.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listTasksForUser(int $userId)
    {
        return $this->taskRepository->getAllTasksByUser($userId);
    }

    /**
     * Crea una nueva tarea asociada a un usuario.
     *
     * @param int $userId ID del usuario.
     * @param array $data Datos de la tarea.
     * @return Task
     */
    public function createTaskForUser(int $userId, array $data): Task
    {
        $data['user_id'] = $userId;
        $data['status'] = $data['status'] ?? 'pending';

        return $this->taskRepository->createTask($data);
    }

    /**
     * Actualiza una tarea específica de un usuario.
     *
     * @param int $taskId ID de la tarea.
     * @param int $userId ID del usuario.
     * @param array $data Datos de la tarea a actualizar.
     * @return Task|null Retorna la tarea actualizada o null si no existe.
     */
    public function updateTaskForUser(int $taskId, int $userId, array $data): ?Task
    {
        $task = $this->taskRepository->getTaskByIdAndUser($taskId, $userId);

        if (!$task) {
            return null;
        }

        return $this->taskRepository->updateTask($task, $data);
    }

    /**
     * Elimina una tarea específica de un usuario.
     *
     * @param int $taskId ID de la tarea.
     * @param int $userId ID del usuario.
     * @return bool|null Retorna true si fue eliminada, o null si no existe.
     */
    public function deleteTaskForUser(int $taskId, int $userId): ?bool
    {
        $task = $this->taskRepository->getTaskByIdAndUser($taskId, $userId);

        if (!$task) {
            return null;
        }

        $this->taskRepository->deleteTask($task);

        return true;
    }

    /**
     * Obtiene una tarea específica de un usuario.
     *
     * @param int $taskId ID de la tarea.
     * @param int $userId ID del usuario.
     * @return Task|null Retorna la tarea o null si no existe.
     */
    public function getTaskByIdForUser(int $taskId, int $userId): ?Task
    {
        return $this->taskRepository->getTaskByIdAndUser($taskId, $userId);
    }
}
