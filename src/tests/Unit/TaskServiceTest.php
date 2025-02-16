<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\TaskService;
use PHPUnit\Framework\TestCase;
use Mockery;

class TaskServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function it_creates_a_task_for_user()
    {
        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskService = new TaskService($taskRepository);

        $userId = 1;
        $taskData = ['title' => 'Test Task', 'description' => 'Test Desc', 'status' => 'pending'];

        $taskRepository->shouldReceive('createTask')
            ->once()
            ->with(array_merge($taskData, ['user_id' => $userId]))
            ->andReturn(new Task(array_merge($taskData, ['user_id' => $userId])));

        $task = $taskService->createTaskForUser($userId, $taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
    }

    /** @test */
    public function it_returns_null_when_task_not_found_on_update()
    {
        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskService = new TaskService($taskRepository);

        $taskRepository->shouldReceive('getTaskByIdAndUser')
            ->once()
            ->with(999, 1)
            ->andReturn(null);

        $task = $taskService->updateTaskForUser(999, 1, ['title' => 'Updated']);

        $this->assertNull($task);
    }
}
