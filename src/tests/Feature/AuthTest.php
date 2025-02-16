<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_register_and_get_jwt_token()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Carlos Martínez',
            'email' => 'carlos.martinez@example.com',
            'password' => 'clave12345',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'token']);
    }

    public function test_user_can_login_and_get_jwt_token()
    {
        $user = User::factory()->create([
            'email' => 'carlos.martinez@example.com',
            'password' => bcrypt('clave12345'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'carlos.martinez@example.com',
            'password' => 'clave12345',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'token']);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'falso@example.com',
            'password' => 'claveincorrecta',
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Credenciales inválidas']);
    }

    public function test_protected_route_requires_jwt_token()
    {
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(401)
            ->assertJson(['error' => 'Token JWT no proporcionado o inválido. Por favor, envía un token válido.']);
    }

    public function test_user_can_access_protected_route_with_valid_token()
    {
        $user = User::factory()->create([
            'name' => 'Carlos Martínez',
            'email' => 'carlos.martinez@example.com',
            'password' => bcrypt('clave12345'),
        ]);

        $token = auth()->login($user);

        $response = $this->getJson('/api/tasks', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }
}
