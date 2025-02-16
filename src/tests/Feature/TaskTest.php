<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario y token
        $this->user = User::factory()->create();
        $this->token = auth()->login($this->user);
    }

    /** @test */
    public function it_can_list_tasks_for_authenticated_user()
    {
        Task::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/tasks', $this->authHeader());

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'Nueva tarea',
            'description' => 'Descripción de la tarea',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $data, $this->authHeader());

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Nueva tarea']);
    }

    /** @test */
    public function it_cannot_create_task_without_title()
    {
        $data = [
            'description' => 'Sin título',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $data, $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_can_show_a_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/tasks/{$task->id}", $this->authHeader());

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    /** @test */
    public function it_cannot_show_a_task_of_another_user()
    {
        $task = Task::factory()->create(); // otra tarea de otro usuario

        $response = $this->getJson("/api/tasks/{$task->id}", $this->authHeader());

        $response->assertStatus(404)
            ->assertJson(['error' => 'Tarea no encontrada']);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $data = ['title' => 'Tarea actualizada'];

        $response = $this->putJson("/api/tasks/{$task->id}", $data, $this->authHeader());

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Tarea actualizada']);
    }

    /** @test */
    public function it_cannot_update_a_task_of_another_user()
    {
        $task = Task::factory()->create(); // otro usuario

        $response = $this->putJson("/api/tasks/{$task->id}", ['title' => 'Modificado'], $this->authHeader());

        $response->assertStatus(404)
            ->assertJson(['error' => 'Tarea no encontrada']);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}", [], $this->authHeader());

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);
    }

    /** @test */
    public function it_cannot_delete_a_task_of_another_user()
    {
        $task = Task::factory()->create(); // otro usuario

        $response = $this->deleteJson("/api/tasks/{$task->id}", [], $this->authHeader());

        $response->assertStatus(404)
            ->assertJson(['error' => 'Tarea no encontrada']);
    }

    private function authHeader(): array
    {
        return ['Authorization' => 'Bearer ' . $this->token];
    }
}
