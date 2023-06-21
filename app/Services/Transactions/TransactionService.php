<?php

namespace App\Services\Transactions;

use App\Enums\OperationEnum;
use App\Enums\RegisterTypeEnum;
use App\Helpers\TransactionHelper;
use App\Enums\TransactionStatusEnum;
use App\Repositories\AccountRepository;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Requests\CreateTransactionDto;
use App\Repositories\TransactionRepository;
use App\Services\AuthorizingService\AuthorizingService;
use App\Exceptions\ServicesExceptions\ServiceDownException;

class TransactionService
{
    protected $accountRepository;
    protected $authorizingService;
    protected $transactionHelper;
    protected $transactionRepository;

    public function __construct(
        AccountRepository $accountRepository,
        AuthorizingService $authorizingService,
        TransactionHelper $transactionHelper,
        TransactionRepository $transactionRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->authorizingService = $authorizingService;
        $this->transactionHelper = $transactionHelper;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Consult the authorizing service.
     * 
     * @return bool
     */
    public function authorizeServiceProvider(): bool
    {
        $authorizerServiceProvider = $this->authorizingService->getAuthorizer();
        return $this->checkAuthorizerServiceProvider($authorizerServiceProvider);
    }

    /**
     * Cancel the transaction in the database.
     * 
     * @param CreateTransactionDto $createtransactionDto
     * @return bool
     */
    public function cancelTransaction(CreateTransactionDto $createTransactionDto): bool
    {
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::NOT, $createTransactionDto);
    }

    /**
     * Authorizes the transaction in the database.
     * 
     * @param CreateTransactionDto $createTransactionDto
     * @return bool
     */
    public function authorizeTransaction(CreateTransactionDto $createTransactionDto): bool
    {
        $this->prepareUsersBalance($createTransactionDto);
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::AUT, $createTransactionDto);
    }
    
    /**
     * Starts the calculation for the new balance of the payer and receiver.
     * 
     * @param CreateTransactionDto $createTransactionDto
     * @return void
     */
    private function prepareUsersBalance(CreateTransactionDto $createTransactionDto): void
    {
        $this->updateUsersBalance(
            $createTransactionDto->payer,
            $createTransactionDto->value,
            OperationEnum::SUB
        );

        $this->updateUsersBalance(
            $createTransactionDto->payee,
            $createTransactionDto->value,
            OperationEnum::ADD
        );
    }

    /**
     * Update payer and payee new balance.
     * 
     * @param int $user
     * @param int $transactionValue
     * @param OperationEnum $operation
     * @return bool
     */
    private function updateUsersBalance(int $user, int $transactionValue, OperationEnum $operation): bool
    {
        $account = $this->accountRepository->getAccountByUserId($user);
        $newBalance = $this->transactionHelper->withdrawOrAddBalance($operation, $account->balance, $transactionValue);
        return $this->accountRepository->updateBalanceAccount($newBalance, $user);
    }

    /**
     * Checks the status code of the authorizing service.
     * 
     * @param int $statusCode
     * @return bool
     */
    private function checkAuthorizerServiceProvider(int $statusCode): bool
    {
        if ($statusCode == StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR) {
            return throw new ServiceDownException();
        }

        if (
            $statusCode != StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR &&
            $statusCode != StatusCodeInterface::STATUS_OK
        ) {
            return false;
        }

        return true;
    }
}
