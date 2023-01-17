<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\User;
use Tests\Unit\Models\CreateUserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldCreateUser()
    {
        $createUserDto = CreateUserDtoFactory::userMakeRealFactory([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $response = $this->post('/api/user', $createUserDto->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);
    }

    public function testShouldCreateUsertButUserNotExists()
    {
        $user = User::factory()->createOne([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $createUserDto = CreateUserDtoFactory::userMakeRealFactory($user->toArray());

        $response = $this->post('/api/user', $createUserDto->toArray());
        $response->assertStatus(302);
    }
}
