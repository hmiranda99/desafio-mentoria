<?php

namespace App\Http\Controllers;

use App\Helpers\TransactionHelper;
use App\Enums\TransactionStatusEnum;
use App\Services\TransactionService;
use App\Http\Requests\CreateTransactionDto;
use App\Repositories\TransactionRepository;
use App\Exceptions\ServicesExceptions\ServiceDownException;
use App\Exceptions\UsersExceptions\UserCannotTransactException;
use App\Exceptions\TransactionsExceptions\InsufficientBalanceException;

class TransactionController extends Controller
{
    protected $transactionHelper;
    protected $transactionService;
    protected $transactionRepository;

    public function __construct(
        TransactionHelper $transactionHelper,
        TransactionService $transactionService,
        TransactionRepository $transactionRepository
    ) {
        $this->transactionHelper = $transactionHelper;
        $this->transactionService = $transactionService;
        $this->transactionRepository = $transactionRepository;
    }

    public function createTransaction(CreateTransactionDto $createTransactionDto)
    {
        $createTransactionDto->transaction_hash = $this->transactionHelper->createHashTransaction();

        if (!$this->transactionHelper->canTransact($createTransactionDto->payer)) {
            $this->cancelTransaction($createTransactionDto);
            throw new UserCannotTransactException();
        }

        $this->captureTransaction($createTransactionDto);

        if(!$this->transactionService->authorizeService()){
            $this->errorTransaction($createTransactionDto);
            throw new ServiceDownException();
        }

        $this->authorizeTransaction($createTransactionDto);
    }

    private function captureTransaction(CreateTransactionDto $createTransactionDto)
    {
        if (!$this->transactionHelper->haveBalanceToTransact($createTransactionDto->value, $createTransactionDto->payer)) {
            $this->cancelTransaction($createTransactionDto);
            throw new InsufficientBalanceException();
        }

        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::CAP, $createTransactionDto);
    }

    private function cancelTransaction(CreateTransactionDto $createTransactionDto)
    {
        return $this->transactionRepository->registerTransaction(TransactionStatusEnum::NOT, $createTransactionDto);
    }

    private function errorTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->transactionRepository->registerTransaction(TransactionStatusEnum::ERR, $createTransactionDto);
        return $this->transactionHelper->prepareAddBalance($createTransactionDto->payer, $createTransactionDto->value);
    }

    private function authorizeTransaction(CreateTransactionDto $createTransactionDto)
    {
        $this->transactionRepository->registerTransaction(TransactionStatusEnum::AUT, $createTransactionDto);
        return $this->transactionHelper->prepareAddBalance($createTransactionDto->payee, $createTransactionDto->value);
    }
}
