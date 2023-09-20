<?php

namespace Tests\Integration\Transaction;

use App\Enums\TransactionsTypesEnum;
use App\Http\Requests\CreateTransactionDto;
use App\Models\Account;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\AuthorizingService\AuthorizingService;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Models\AccountDtoFactory;
use Tests\Unit\Models\CreateTransactionDtoFactory;

class CreateTransactionTest extends TestCase
{
    use DatabaseMigrations;

    private AuthorizingService $authorizingService;

    public function setUp(): void
    {
        parent::setUp();
        $this->authorizingService = $this->createMock(AuthorizingService::class);
    }

    public function testShouldCreateTransaction()
    {
        $createTransactionDto = $this->createBaseTransaction(TransactionsTypesEnum::P2B->value);
        $this->mockAuthorizingService(StatusCodeInterface::STATUS_OK);
        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $response->assertStatus(StatusCodeInterface::STATUS_CREATED);
    }

    public function testShouldSellerIsPayerButReturnError()
    {
        $message = response()->json([
            "error" => true,
            "message" => "Seller entity users cannot transact, only receive."
        ]);
        $createTransactionDto = $this->createBaseTransaction(TransactionsTypesEnum::P2B->value, User::SELLER);
        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $this->assertEquals($message->content(), $response->getContent());
    }

    public function testShouldCreateTransactionButTypeIsIncorrect()
    {
        $message = response()->json([
            "error" => true,
            "message" => "Incorrect transaction type."
        ]);

        $createTransactionDto = $this->createBaseTransaction(
            TransactionsTypesEnum::P2B->value,
            User::CONSUMER,
            User::CONSUMER
        );

        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $this->assertEquals($message->content(), $response->getContent());
    }

    public function testShouldTransactButInsufficientBalance()
    {
        $message = response()->json([
            "error" => true,
            "message" => "Insufficient balance."
        ]);

        $createTransactionDto = $this->createBaseTransaction(
            TransactionsTypesEnum::P2B->value,
            User::CONSUMER,
            User::SELLER,
            0
        );

        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $this->assertEquals($message->content(), $response->getContent());
    }

    public function testShouldCreateTransactionButAuthorizerServiceDown()
    {
        $message = response()->json([
            "error" => true,
            "message" => "The service is temporarily down."
        ]);

        $createTransactionDto = $this->createBaseTransaction(TransactionsTypesEnum::P2B->value);
        $this->mockAuthorizingService(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $this->assertEquals($message->content(), $response->getContent());
    }

    public function testShouldCreateTransactionButTransactionNotAuthorized()
    {
        $message = response()->json([
            "error" => true,
            "message" => "Transaction not authorized."
        ]);

        $createTransactionDto = $this->createBaseTransaction(TransactionsTypesEnum::P2B->value);
        $this->mockAuthorizingService(StatusCodeInterface::STATUS_BAD_REQUEST);
        $response = $this->post('api/transaction', $createTransactionDto->toArray());
        $this->assertEquals($message->content(), $response->getContent());
    }

    public function createBaseTransaction(
        string $transactionType,
        string $payerType = User::CONSUMER,
        string $payeeType = User::SELLER,
        float $payerBalance = 100
    ): CreateTransactionDto {
        TransactionType::factory()->createOne([
            'description' => $transactionType
        ]);

        $payer = User::factory()->createOne([
            'id' => 10,
            'cpf' => '271.846.355-40',
            'cnpj' => null,
            'user_entity' => $payerType
        ]);

        $payee = User::factory()->createOne([
            'id' => 20,
            'cpf' => '271.846.355-50',
            'cnpj' => null,
            'user_entity' => $payeeType
        ]);

        $accountPayer = AccountDtoFactory::accountMakeRealFactory([
            'user_id' => $payer->id,
            'balance' => $payerBalance
        ]);
        Account::factory()->createOne($accountPayer->toArray());

        $accountPayee = AccountDtoFactory::accountMakeRealFactory(['user_id' => $payee->id]);
        Account::factory()->createOne($accountPayee->toArray());

        return CreateTransactionDtoFactory::makeRealFactory([
            'payer' => $payer->id,
            'payee' => $payee->id,
            'type' => $transactionType
        ]);
    }

    public function mockAuthorizingService(int $statusCode): void
    {
        $this->authorizingService
            ->method('getAuthorizer')
            ->willReturn($statusCode);

        $this->instance(AuthorizingService::class, $this->authorizingService);
    }
}
