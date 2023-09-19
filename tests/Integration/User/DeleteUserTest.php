<?php

namespace Tests\Integration\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldDeleteUserById()
    {
        $user = User::factory()->createOne();

        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);

        $response = $this->delete("api/delete/user/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function testShouldDeleteUserByIdButUserNotExists()
    {
        $id = 0;
        $message = response()->json(["error" => true, "message" => "This user does not exist in the database."]);

        $response = $this->delete("api/delete/user/{$id}");

        $response->assertStatus(400);
        $this->assertEquals($message->content(), $response->getContent());
    }
}
