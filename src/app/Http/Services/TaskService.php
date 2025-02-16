<?php

namespace App\Http\Services;

use App\Http\Repositories\TaskRepository;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function listTasksForUser($userId)
    {
        return $this->taskRepository->getAllTasksByUser($userId);
    }

    public function createTaskForUser($userId, array $data)
    {
        $data['user_id'] = $userId;
        $data['status'] = $data['status'] ?? 'pending';

        return $this->taskRepository->createTask($data);
    }

    public function updateTaskForUser($taskId, $userId, array $data)
    {
        $task = $this->taskRepository->getTaskByIdAndUser($taskId, $userId);

        if (!$task) {
            return null;
        }

        return $this->taskRepository->updateTask($task, $data);
    }

    public function deleteTaskForUser($taskId, $userId)
    {
        $task = $this->taskRepository->getTaskByIdAndUser($taskId, $userId);

        if (!$task) {
            return null;
        }

        $this->taskRepository->deleteTask($task);

        return true;
    }

    public function getTaskByIdForUser($taskId, $userId)
    {
        return $this->taskRepository->getTaskByIdAndUser($taskId, $userId);
    }
}
