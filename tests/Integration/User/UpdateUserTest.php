<?php

namespace Tests\Integration\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tests\Unit\Models\UserDtoFactory;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldUpdateUser()
    {
        $user = User::factory()->createOne([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $request = new Request($user->toArray());
        $request->name = "José da Silva";

        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);

        $response = $this->put("api/update/user/{$user->id}", $request->toArray());

        $this->assertEmpty($response->getContent());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'name' => $request->name
        ]);
    }

    public function testShouldUpdateUserButUserNotExists()
    {
        $message = response()->json(["error" => true, "message" => "This user does not exist in the database."]);

        $userDto = UserDtoFactory::makeRealFactory([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $request = new Request($userDto->toArray());

        $response = $this->put("api/update/user/{$userDto->id}", $request->toArray());

        $response->assertStatus(400);
        $this->assertEquals($message->content(), $response->getContent());
    }
}
