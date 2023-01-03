<?php

namespace Tests\Unit\Repositories;

use App\Models\Account;
use App\Models\AccountDto;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\AccountRepository;
use Tests\Unit\Models\UserDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Unit\Models\AccountDtoFactory;

class AccountRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldGetAccountByUserId()
    {
        $user = User::factory()->createOne();
        $account = Account::factory()->createOne(['user_id' => $user->id]);
        $accountDto = AccountDtoFactory::accountMakeRealFactory($account->toArray());

        $instance = new AccountRepository();
        $response = $instance->getAccountByUserId($user->id);

        $this->assertInstanceOf(AccountDto::class, $response);
        $this->assertEquals($accountDto->number, $response->number);
    }

    public function testShouldGetAccountByUserIdButUserNotExists()
    {
        $userDto = UserDtoFactory::userMakeRealFactory();

        $instance = new AccountRepository();
        $response = $instance->getAccountByUserId($userDto->id);

        $this->assertNull($response);
    }

    public function testShouldDeleteAccount()
    {
        $user = User::factory()->createOne();
        Account::factory()->createOne(['user_id' => $user->id]);

        $instance = new AccountRepository();
        $response = $instance->deleteAccountByUserId($user->id);

        $this->assertTrue($response);
    }
}
