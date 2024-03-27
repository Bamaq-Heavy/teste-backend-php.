<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testCriaUser()
    {
        $userDados = [
            'name' => 'Maria da Silva',
            'email' => 'mariasilva@mail.com',
            'cpf' => '12345678900',
            'password' => 'senha123',
        ];

        $response = $this->postJson('/api/user', $userDados);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Maria da Silva',
                     'email' => 'mariasilva@mail.com',
                 ]);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $dadosAtualizados = [
            'name' => 'Maria da Silva Atualizada',
            'email' => 'mariasilva@mail.com',
            'cpf' => '98765432100',
            'password' => '123senha',
        ];

        $response = $this->putJson("/api/user/{$user->id}", $dadosAtualizados);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Maria da Silva Atualizada',
                     'email' => 'mariasilva@mail.com',
                 ]);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/user/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
