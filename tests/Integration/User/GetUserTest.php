<?php

namespace Tests\Integration\User;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldGetUserById()
    {
        $user = User::factory()->createOne();
        Account::factory()->createOne(['user_id' => $user->id]);

        $response = $this->get("api/user/{$user->id}", ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $this->assertEquals($user->id, $response->json('id'));
    }

    public function testShouldGetUserByIdButUserNotExists()
    {
        $id = 0;
        $message = response()->json(["error" => true, "message" => "This user does not exist in the database."]);

        $response = $this->get("api/user/{$id}", ['Accept' => 'application/json']);

        $response->assertStatus(400);
        $this->assertEquals($message->content(), $response->getContent());
    }
}
