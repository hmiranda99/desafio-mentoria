<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Adapters\UserDtoAdapter;
use App\Repositories\UserRepository;
use Tests\Unit\Models\UserDtoFactory;
use App\Http\Controllers\UserController;
use Fig\Http\Message\StatusCodeInterface;
use Tests\Unit\Models\CreateUserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Exceptions\UsersExceptions\UserNotExistsException;
use App\Exceptions\UsersExceptions\UserAlreadExistsException;
use App\Repositories\AccountRepository;
use Tests\Unit\Models\AccountDtoFactory;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $userRepository;
    private $userDtoAdapter;
    private $userHelper;
    private $accountRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userDtoAdapter = $this->createMock(UserDtoAdapter::class);
        $this->userHelper = $this->createMock(UserHelper::class);
        $this->accountRepository = $this->createMock(AccountRepository::class);
    }

    public function testShouldCreateUser()
    {
        $passwordEncrypt = '$2y$10$/UIAUCtO9gQaCXp5cQJj6eL332sMUzJDDu/6m31ZeJ9Oj1pkJNA3.';
        $createUserDto = CreateUserDtoFactory::userMakeRealFactory(['password' => '1234567', 'user_entity' => User::SELLER]);
        $userDto = UserDtoFactory::userMakeRealFactory($createUserDto->toArray());
        $accountDto = AccountDtoFactory::accountMakeRealFactory();

        $this->userRepository
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($createUserDto->email)
            ->willReturn(null);

        $this->userHelper
            ->expects($this->once())
            ->method('definesUserEntity')
            ->with($createUserDto->cnpj)
            ->willReturn(User::SELLER);

        $this->userHelper
            ->expects($this->once())
            ->method('encryptPassword')
            ->with($createUserDto->password)
            ->willReturn($passwordEncrypt);

        $this->userDtoAdapter
            ->expects($this->once())
            ->method('adapter')
            ->with($createUserDto)
            ->willReturn($userDto);

        $this->userRepository
            ->expects($this->once())
            ->method('createUser')
            ->with($userDto)
            ->willReturn($userDto);

        $this->accountRepository
            ->expects($this->once())
            ->method('getAccountByUserId')
            ->with($userDto->id)
            ->willReturn($accountDto);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->createUser($createUserDto);

        $this->assertEquals(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertNotEmpty($response);
    }

    public function testShouldCreateUserButUserAlreadyExists()
    {
        $createUserDto = CreateUserDtoFactory::userMakeFactory();
        User::factory()->createOne($createUserDto->toArray());
        $userDto = UserDtoFactory::userMakeRealFactory($createUserDto->toArray());

        $this->userRepository
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($createUserDto->email)
            ->willReturn($userDto);

        $this->expectException(UserAlreadExistsException::class);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->createUser($createUserDto);

        $this->assertEquals(StatusCodeInterface::STATUS_CONFLICT, $response->getStatusCode());
    }

    public function testShouldGetUserById()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory();
        $accountDto = AccountDtoFactory::accountMakeRealFactory();

        $this->accountRepository
            ->expects($this->once())
            ->method('getAccountByUserId')
            ->with($user->id)
            ->willReturn($accountDto);

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($user->id)
            ->willReturn($userDto);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->getUser($user->id);

        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertNotEmpty($response);
    }

    public function testShouldGetUserByIdButUserNotExists()
    {
        $id = 0;

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($id)
            ->willThrowException(new UserNotExistsException());

        $this->expectException(UserNotExistsException::class);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->getUser($id);

        $this->assertEquals(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }

    public function testShouldDeleteUser()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory();

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($user->id)
            ->willReturn($userDto);

        $this->userRepository
            ->expects($this->once())
            ->method('deleteUser')
            ->with($user->id)
            ->willReturn(true);

        $this->accountRepository
            ->expects($this->once())
            ->method('deleteAccountByUserId')
            ->with($user->id)
            ->willReturn(true);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->deleteUser($user->id);

        $this->assertEquals(StatusCodeInterface::STATUS_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testShouldDeleteUserButUserNotExistis()
    {
        $id = 0;

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($id)
            ->willThrowException(new UserNotExistsException());

        $this->expectException(UserNotExistsException::class);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->deleteUser($id);

        $this->assertEquals(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }

    public function testShouldUpdateUser()
    {
        $user = User::factory()->createOne();
        $userDto = UserDtoFactory::userMakeRealFactory();
        $request = new Request($user->toArray());

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($user->id)
            ->willReturn($userDto);

        $this->userHelper
            ->expects($this->once())
            ->method('definesUserEntity')
            ->with($user->cnpj)
            ->willReturn(User::SELLER);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->updateUser($user->id, $request);

        $this->assertEquals(StatusCodeInterface::STATUS_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testShouldUpdateUserButUserNotExists()
    {
        $id = 0;
        $request = new Request();

        $this->userHelper
            ->expects($this->once())
            ->method('hasUser')
            ->with($id)
            ->willThrowException(new UserNotExistsException());

        $this->expectException(UserNotExistsException::class);

        $instance = new UserController($this->userRepository, $this->userDtoAdapter, $this->userHelper, $this->accountRepository);
        $response = $instance->updateUser($id, $request);

        $this->assertEquals(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
