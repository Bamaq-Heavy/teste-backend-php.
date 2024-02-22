<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Autenticar um usuário de teste e obter o token JWT
        $this->token = $this->authenticateUser();
    }

    private function authenticateUser()
    {
        // Crie um usuário de teste com dados falsos
        $userData = [
            'nome' => 'John Doe',
            'cpf' => '12345678901', // CPF de exemplo (11 dígitos)
            'email' => Str::random(10) . '@example.com', // Gera um endereço de e-mail aleatório
            'password' => bcrypt('password'), // Use bcrypt para criptografar a senha
        ];
        
        $user = User::create($userData);

        // Gere e retorne um token JWT válido para o usuário
        return JWTAuth::fromUser($user);
    }

    public function test_can_create_user()
    {
        $userData = [
            'nome' => 'John Doe',
            'cpf' => '12345678901', // CPF de exemplo (11 dígitos)
            'email' => Str::random(10) . '@example.com', // Gera um endereço de e-mail aleatório
            'password' => 'password',
        ];

        $response = $this->postJson('user', $userData, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'nome' => 'John Doe',
                'email' => $userData['email'],
            ]);

        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $userData = [
            'nome' => 'Nome atualizado',
            'email' => Str::random(10) . '@example.com', // Gera um endereço de e-mail aleatório
        ];

        $response = $this->putJson('/api/user/' . $user->id, $userData, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'nome' => 'Nome atualizado',
                'email' => $userData['email'],
            ]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'nome' => 'Nome atualizado', 'email' => $userData['email']]);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/user/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_show_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/user/' . $user->id, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'nome' => $user->nome,
                'email' => $user->email,
            ]);
    }
}
