<?php

namespace App\Http\Controllers;

use App\Enums\OperationEnum;
use App\Enums\TransactionStatusEnum;
use App\Services\TransactionService;
use App\Repositories\AccountRepository;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Requests\CreateTransactionDto;
use App\Repositories\TransactionRepository;
use App\Exceptions\TransactionsExceptions\TransactionNotAuthorizedException;
use App\Helpers\TransactionHelper;
use App\Jobs\FinalTransactionEmail;

class TransactionController extends Controller
{
    protected $accountRepository;
    protected $transactionHelper;
    protected $transactionRepository;
    protected $transactionService;
    protected $validateTransaction;

    public function __construct(
        AccountRepository $accountRepository,
        TransactionHelper $transactionHelper,
        TransactionRepository $transactionRepository,
        TransactionService $transactionService,
        ValidateTransaction $validateTransaction
    ) {
        $this->transactionHelper = $transactionHelper;
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transactionService = $transactionService;
        $this->validateTransaction = $validateTransaction;
    }

    public function createTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->validateTransaction->handle($createTransactionDto);

        if (!$this->transactionService->authorizeService()) {
            $this->cancelTransaction($createTransactionDto);
            throw new TransactionNotAuthorizedException();
        }

        $this->authorizeTransaction($createTransactionDto);

        FinalTransactionEmail::dispatch();

        return response(null, StatusCodeInterface::STATUS_CREATED);
    }

    private function cancelTransaction(CreateTransactionDto $createTransactionDto)
    {
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::NOT, $createTransactionDto);
    }

    private function authorizeTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->prepareUsersBalance($createTransactionDto);
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::AUT, $createTransactionDto);
    }

    private function prepareUsersBalance(CreateTransactionDto $createTransactionDto)
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
    
    private function updateUsersBalance(int $user, int $transactionValue, OperationEnum $operation)
    {
        $account = $this->accountRepository->getAccountByUserId($user);
        $newBalance = $this->transactionHelper->withdrawOrAddBalance($operation, $account->balance, $transactionValue);
        return $this->accountRepository->updateBalanceAccount($newBalance, $user);
    }
}
