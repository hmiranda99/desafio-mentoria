<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Helpers\TransactionHelper;
use App\Services\TransactionService;
use Tests\Unit\Models\UserDtoFactory;
use Tests\Unit\Models\AccountDtoFactory;
use Fig\Http\Message\StatusCodeInterface;
use App\Repositories\TransactionRepository;
use Tests\Unit\Models\CreateUserDtoFactory;
use App\Http\Controllers\TransactionController;
use Tests\Unit\Models\CreateTransactionDtoFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Exceptions\ServicesExceptions\ServiceDownException;
use App\Exceptions\UsersExceptions\UserCannotTransactException;

class TransactionControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $transactionHelper;
    private $transactionService;
    private $transactionRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionHelper = $this->createMock(TransactionHelper::class);
        $this->transactionService = $this->createMock(TransactionService::class);
        $this->transactionRepository = $this->createMock(TransactionRepository::class);
    }
/*
    public function testCreateTransaction()
    {
        $payer = User::factory()->createOne([
            'id' => 10, 
            'cpf' => '271.846.355-40',
            'cnpj' => null,
            'user_entity' => User::CONSUMER
        ]);

        $payee = User::factory()->createOne([
            'id' => 20, 
            'cpf' => '271.846.355-50',
            'cnpj' => null,
            'user_entity' => User::CONSUMER
        ]);

        $accountPayer = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payer->id]);
        Account::factory()->createOne($accountPayer->toArray());

        $accountPayee = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payee->id]);
        Account::factory()->createOne($accountPayee->toArray());

        $createTransactionDto = CreateTransactionDtoFactory::makeRealFactory([
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);

        $this->transactionHelper
        ->expects($this->once())
        ->method('canTransact')
        ->with($createTransactionDto->payer)
        ->willReturn(true);

        $this->transactionService
        ->expects($this->once())
        ->method('captureTransaction')
        ->with($createTransactionDto)
        ->willReturn(true);

        $this->transactionService
        ->expects($this->once())
        ->method('authorizeService')
        ->willReturn(true);

        $this->transactionService
        ->expects($this->once())
        ->method('authorizeTransaction')
        ->with($createTransactionDto)
        ->willReturn(true);

        $instance = new TransactionController($this->transactionHelper, $this->transactionService, $this->transactionRepository);

        $response = $instance->createTransaction($createTransactionDto);

        $this->assertEquals(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
    }

    public function testShouldCreateTransactionButPyerIsSeller()
    {
        $payer = User::factory()->createOne([
            'id' => 10, 
            'cpf' => null,
            'user_entity' => User::SELLER
        ]);

        $payee = User::factory()->createOne([
            'id' => 20, 
            'cpf' => null,
            'user_entity' => User::SELLER
        ]);

        $accountPayer = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payer->id]);
        Account::factory()->createOne($accountPayer->toArray());

        $accountPayee = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payee->id]);
        Account::factory()->createOne($accountPayee->toArray());

        $createTransactionDto = CreateTransactionDtoFactory::makeRealFactory([
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);

        $this->transactionHelper
        ->expects($this->once())
        ->method('canTransact')
        ->with($createTransactionDto->payer)
        ->willReturn(false);

        $this->transactionService
        ->expects($this->once())
        ->method('cancelTransaction')
        ->with($createTransactionDto)
        ->willReturn(true);

        $this->expectException(UserCannotTransactException::class);

        $instance = new TransactionController($this->transactionHelper, $this->transactionService, $this->transactionRepository);

        $response = $instance->createTransaction($createTransactionDto);

        $this->assertEquals(StatusCodeInterface::STATUS_FORBIDDEN, $response->getStatusCode());
    }

    public function testShouldCreateTransactionButServiceDown()
    {
        $payer = User::factory()->createOne([
            'id' => 10, 
            'cpf' => '271.846.355-40',
            'cnpj' => null,
            'user_entity' => User::CONSUMER
        ]);

        $payee = User::factory()->createOne([
            'id' => 20, 
            'cpf' => '271.846.355-50',
            'cnpj' => null,
            'user_entity' => User::CONSUMER
        ]);

        $accountPayer = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payer->id]);
        Account::factory()->createOne($accountPayer->toArray());

        $accountPayee = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payee->id]);
        Account::factory()->createOne($accountPayee->toArray());

        $createTransactionDto = CreateTransactionDtoFactory::makeRealFactory([
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);

        $this->transactionHelper
        ->expects($this->once())
        ->method('canTransact')
        ->with($createTransactionDto->payer)
        ->willReturn(true);

        $this->transactionService
        ->expects($this->once())
        ->method('captureTransaction')
        ->with($createTransactionDto)
        ->willReturn(true);

        $this->transactionService
        ->expects($this->once())
        ->method('authorizeService')
        ->willReturn(false);

        $this->transactionService
        ->expects($this->once())
        ->method('errorTransaction')
        ->willReturn(true);

        $this->expectException(ServiceDownException::class);

        $instance = new TransactionController($this->transactionHelper, $this->transactionService, $this->transactionRepository);

        $response = $instance->createTransaction($createTransactionDto);

        $this->assertEquals(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }*/
}
