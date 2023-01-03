<?php

namespace Tests\Unit\Repositories;

use App\Helpers\AccountHelper;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDto;
use App\Repositories\UserRepository;
use Tests\Unit\Models\UserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $accountHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountHelper = $this->createMock(AccountHelper::class);
    }

    public function testShouldGetUserByEmail()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->getUserByEmail($user->email);

        $this->assertInstanceOf(UserDto::class, $response);
        $this->assertEquals($userDto->email, $response->email);
    }

    public function testShouldGetUserByEmailButUserNotExists()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->getUserByEmail($userDto->email);

        $this->assertNull($response);
    }

    public function testShouldGetUserById()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->getUserById($user->id);

        $this->assertInstanceOf(UserDto::class, $response);
        $this->assertEquals($userDto->id, $response->id);
    }

    public function testShouldGetUserByIdButUserNotExists()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->getUserById($userDto->id);

        $this->assertNull($response);
    }

    public function testShouldCreateUser()
    {
        $array = [
            'number' => "111574225-9",
            'balance' => 128.5
        ];

        $this->accountHelper
            ->expects($this->once())
            ->method('accountUserData')
            ->willReturn($array);

        $userDto = UserDtoFactory::userMakeRealFactory();
        $userDto->id = null;

        $instance = new UserRepository($this->accountHelper);

        $response = $instance->createUser($userDto);


        $this->assertDatabaseHas('users', [
            'id' => $response->id,
        ]);
    }

    public function testShouldDeleteUser()
    {
        $user = User::factory()->createOne();

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->deleteUser($user->id);

        $this->assertTrue($response);
    }

    public function testShouldUpdateUser()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory($user->toArray());

        $instance = new UserRepository($this->accountHelper);
        $response = $instance->updateUser($userDto, $userDto->id);

        $this->assertTrue($response);
    }
}
