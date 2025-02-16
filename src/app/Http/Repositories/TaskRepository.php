<?php

namespace App\Http\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAllTasksByUser($userId)
    {
        return Task::where('user_id', $userId)
            ->get();
    }

    public function getTaskByIdAndUser($id, $userId)
    {
        return Task::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
