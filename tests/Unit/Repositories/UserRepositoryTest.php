<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserDto;
use App\Repositories\UserRepository;
use Tests\Unit\Models\UserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testSholdGetUserByEmail()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository;
        $response = $instance->getUserByEmail($user->email);
        
        $this->assertInstanceOf(UserDto::class, $response);
        $this->assertEquals($userDto->email, $response->email);
    }

    public function testSholdGetUserByEmailButUserNotExists()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();

        $instance = new UserRepository;
        $response = $instance->getUserByEmail($userDto->email);
        
        $this->assertNull($response);
    }

    public function testSholdGetUserById()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository;
        $response = $instance->getUserById($user->id);
        
        $this->assertInstanceOf(UserDto::class, $response);
        $this->assertEquals($userDto->id, $response->id);
    }

    public function testSholdGetUserByIdButUserNotExists()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();

        $instance = new UserRepository;
        $response = $instance->getUserById($userDto->id);
        
        $this->assertNull($response);
    }

    public function testSholdCreateUser()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();
        $userDto->id = null;

        $instance = new UserRepository;

        $response = $instance->createUser($userDto);

        
        $this->assertDatabaseHas('users', [
            'id' => $response->id,
        ]);
    }

    public function testSholdDeleteUser()
    {
        $user = User::factory()->createOne();

        $instance = new UserRepository;
        $response = $instance->deleteUser($user->id);

        $this->assertTrue($response);
    }

    public function testSholdUpdateUser()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository;
        $response = $instance->updateUser($userDto, $userDto->id);

        $this->assertTrue($response);
    }
}