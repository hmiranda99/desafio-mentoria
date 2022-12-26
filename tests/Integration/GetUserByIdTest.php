<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GetUserByIdTest extends TestCase
{
    use DatabaseMigrations;
    
    /*
    public function testSholdCreateUserRoute()
    {
        $user = User::factory()->createOne();

        $response = $this->get('/list/user/{$user}');
        $response->assertStatus(200);
    }

    public function testSholdCreateUsertButUserNotExistsRoute()
    {
        $user = User::factory()->createOne([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $createUserDto = CreateUserDtoFactory::userMakeRealFactory($user->toArray());

        $response = $this->post('/api/create-users', $createUserDto->toArray());
        $response->assertStatus(302);
    }*/
}