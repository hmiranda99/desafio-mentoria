<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Models\User;
use App\Helpers\UserHelper;
use App\Repositories\UserRepository;
use Tests\Unit\Models\UserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Exceptions\UsersExceptions\UserNotExistsException;
use Illuminate\Http\Request;

class UserHelperTest extends TestCase
{
    use DatabaseMigrations;
    
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testShouldDefineUserTypeAsSeller()
    {
        $cnpj = "54.674.564/0001-39";
        $instance = new UserHelper($this->userRepository);
        $response = $instance->definesUserEntity($cnpj);

        $this->assertEquals(User::SELLER, $response);
        $this->assertIsString($response);
    }

    public function testShouldDefineUserTypeAsConsumer()
    {
        $cnpj = null;
        $instance = new UserHelper($this->userRepository);
        $response = $instance->definesUserEntity($cnpj);

        $this->assertEquals(User::CONSUMER, $response);
        $this->assertIsString($response);
    }

    public function testSholdHaveUserInDatabase()
    {
        $userId = 1;
        $userDto = UserDtoFactory::userMakeRealFactory(['id' => $userId]);

        $this->userRepository
            ->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn($userDto);

        $instance = new UserHelper($this->userRepository);
        $response = $instance->hasUser($userId);

        $this->assertEquals($userDto, $response);  
        $this->assertNotEmpty($response);
    }

    public function testDontSholdHaveUserInDatabase()
    {
        $userId = 0;

        $this->userRepository
            ->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn(null);

        $this->expectException(UserNotExistsException::class);

        $instance = new UserHelper($this->userRepository);
        $response = $instance->hasUser($userId);

        $this->assertNull($response);
    }

    public function testSholdHaveApplyRulesInUpdate()
    {
        $userDto = UserDtoFactory::userMakeRealFactory(['cnpj' => '54.674.564/0001-39', 'cpf' => '271.846.355-40']);
        $message = response()->json(["email" => "The email must be a valid email address."]);
        $request = new Request($userDto->toArray());
        
        $this->expectException(\Exception::class);

        $instance = new UserHelper($this->userRepository);
        $response = $instance->validateRequestUpdate($request, $userDto);
        
        $this->assertEquals($message->getContent(), $response);
    }

    public function testSholdDontHaveApplyRulesInUpdate()
    {
        $userDto = UserDtoFactory::userMakeRealFactory([
            'email' => 'email@email.com',
            'cnpj' => '54.674.564/0001-39',
            'cpf' => '271.846.355-40'
        ]);
        $request = new Request($userDto->toArray());

        $instance = new UserHelper($this->userRepository);
        $response = $instance->validateRequestUpdate($request, $userDto);

        $this->assertEmpty($response);
    }

    public function testSholdDontHaveNewPassword()
    {
        $userId = 1;
        $password = "$2y$04udJz4ZISd27/d8Td3GRoserpoizlqFCPpTYR3KXtSaaPjxsa0uEOO";

        User::factory()->createOne(['id' => $userId, 'password' => $password]);
        $userDto = UserDtoFactory::userMakeRealFactory(['id' => $userId, 'password' => $password]);

        $this->userRepository
            ->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn($userDto);

        $instance = new UserHelper($this->userRepository);
        $response = $instance->hasNewPassword($password, $userId);

        $this->assertEquals($userDto->password, $response);
        $this->assertIsString($response);
    }

    public function testSholdHaveNewPassword()
    {
        $userId = 1;
        $password = "$2y$04udJz4ZISd27/d8Td3GRoserpoizlqFCPpTYR3KXtSaaPjxsa0uEOO";

        User::factory()->createOne(['id' => $userId]);
        $userDto = UserDtoFactory::userMakeRealFactory(['id' => $userId]);

        $this->userRepository
            ->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn($userDto);

        $instance = new UserHelper($this->userRepository);
        $response = $instance->hasNewPassword($password, $userId);

        $this->assertNotEquals($userDto->password, $response);
        $this->assertIsString($response);
    }
}
