<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    /**
     * Obtiene todas las tareas de un usuario.
     *
     * @param int $userId ID del usuario.
     */
    public function getAllTasksByUser(int $userId): LengthAwarePaginator
    {
        return Task::where('user_id', $userId)
            ->paginate(10);
    }

    /**
     * Obtiene una tarea específica por ID que pertenezca a un usuario.
     *
     * @param int $id ID de la tarea.
     * @param int $userId ID del usuario.
     * @return Task|null
     */
    public function getTaskByIdAndUser(int $id, int $userId): ?Task
    {
        return Task::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Crea una nueva tarea con los datos proporcionados.
     *
     * @param array $data Datos de la tarea.
     * @return Task
     */
    public function createTask(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Actualiza los campos de una tarea específica.
     *
     * @param Task $task Instancia de la tarea a actualizar.
     * @param array $data Datos a actualizar.
     * @return Task
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    /**
     * Elimina una tarea específica.
     *
     * @param Task $task Instancia de la tarea a eliminar.
     * @return void
     */
    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
