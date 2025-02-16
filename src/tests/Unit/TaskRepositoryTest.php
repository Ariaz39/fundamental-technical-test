<?php

namespace Tests\Unit;

use App\Http\Repositories\TaskRepository;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected TaskRepository $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = new TaskRepository();
    }

    /** @test */
    public function it_creates_a_task()
    {
        $user = User::factory()->create();

        $task = $this->taskRepository->createTask([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
        $this->assertInstanceOf(Task::class, $task);
    }


    /** @test */
    public function it_returns_null_when_task_not_found()
    {
        $task = $this->taskRepository->getTaskByIdAndUser(999, 1);

        $this->assertNull($task);
    }
}
