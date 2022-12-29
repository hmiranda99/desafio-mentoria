<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GetUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldGetUserById()
    {
        $user = User::factory()->createOne();
        Account::factory()->createOne(['user_id' => $user->id]);

        $response = $this->get("api/list/user/{$user->id}", ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $this->assertEquals($user->id, $response->json('id'));
    }

    public function testShouldGetUserByIdButUserNotExists()
    {
        $id = 0;
        $message = response()->json(["error" => true, "message" => "This user does not exist in the database."]);

        $response = $this->get("api/list/user/{$id}", ['Accept' => 'application/json']);

        $response->assertStatus(400);
        $this->assertEquals($message->content(), $response->getContent());
    }
}
