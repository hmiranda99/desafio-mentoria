<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Models\User;
use App\Helpers\TransactionHelper;
use App\Repositories\UserRepository;
use Tests\Unit\Models\UserDtoFactory;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TransactionHelperTest extends TestCase
{
    use DatabaseMigrations;

    private $accountRepository;
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testShouldCanTransact()
    {
        $user = User::factory()->makeOne(['user_entity' => User::CONSUMER]);
        $userDto = UserDtoFactory::makeRealFactory($user->toArray());

        $this->userRepository
        ->expects($this->once())
        ->method('getUserById')
        ->with($user->id)
        ->willReturn($userDto);

        $instance = new TransactionHelper($this->accountRepository, $this->userRepository);
        $reponse = $instance->canTransact($user->id);

        $this->assertTrue($reponse);
    }

    public function testShouldNotCanTransact()
    {
        $user = User::factory()->makeOne(['user_entity' => User::SELLER]);
        $userDto = UserDtoFactory::makeRealFactory($user->toArray());

        $this->userRepository
        ->expects($this->once())
        ->method('getUserById')
        ->with($user->id)
        ->willReturn($userDto);

        $instance = new TransactionHelper($this->accountRepository, $this->userRepository);
        $reponse = $instance->canTransact($user->id);

        $this->assertFalse($reponse);
    }
}