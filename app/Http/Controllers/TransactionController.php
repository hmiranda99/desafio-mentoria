<?php

namespace App\Http\Controllers;

use App\Helpers\TransactionHelper;
use App\Services\TransactionService;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Requests\CreateTransactionDto;
use App\Exceptions\ServicesExceptions\ServiceDownException;
use App\Exceptions\UsersExceptions\UserCannotTransactException;

class TransactionController extends Controller
{
    protected $transactionHelper;
    protected $transactionService;

    public function __construct(
        TransactionHelper $transactionHelper,
        TransactionService $transactionService
    ) {
        $this->transactionHelper = $transactionHelper;
        $this->transactionService = $transactionService;
    }

    public function createTransaction(CreateTransactionDto $createTransactionDto)
    {
        $createTransactionDto->transactionHash = $this->transactionHelper->createHashTransaction();

        if (!$this->transactionHelper->canTransact($createTransactionDto->payer)) {
            $this->transactionService->cancelTransaction($createTransactionDto);
            throw new UserCannotTransactException();
        }

        $this->transactionService->captureTransaction($createTransactionDto);

        if (!$this->transactionService->authorizeService()) {
            $this->transactionService->errorTransaction($createTransactionDto);
            throw new ServiceDownException();
        }

        $this->transactionService->authorizeTransaction($createTransactionDto);

        return response(null, StatusCodeInterface::STATUS_CREATED);
    }
}
