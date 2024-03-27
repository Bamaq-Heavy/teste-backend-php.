<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testCriaUsuario()
    {
        $userData = [
            'name' => 'Maria da Silva',
            'email' => 'mariasilva@mail.com',
            'cpf' => '12345678900',
            'password' => 'senha123',
        ];

        $user = $this->userService->createUser($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'mariasilva@mail.com']);
    }

    public function testUpdateUsuario()
    {
        $user = User::factory()->create();

        $dataAtualizado = [
            'name' => 'Maria da Silva Atualizada',
            'email' => 'mariasilva@mail.com',
            'cpf' => '98765432100',
            'password' => '123senha',
        ];

        $userAtualizado = $this->userService->updateUser($dataAtualizado,$user->id);

        $this->assertInstanceOf(User::class, $userAtualizado);
        $this->assertEquals('Maria da Silva Atualizada', $userAtualizado->name);
        $this->assertEquals('mariasilva@mail.com', $userAtualizado->email);
    }

    public function testDeleteUsuario()
    {
        $user = User::factory()->create();

        $this->userService->deleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
