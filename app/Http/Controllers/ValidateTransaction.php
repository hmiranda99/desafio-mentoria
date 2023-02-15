<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;
use App\Http\Requests\CreateTransactionDto;
use App\Exceptions\UsersExceptions\UserCannotTransactException;
use App\Exceptions\TransactionsExceptions\InsufficientBalanceException;

class ValidateTransaction
{
    protected $accountRepository;
    protected $userRepository;

    public function __construct(
        AccountRepository $accountRepository,
        UserRepository $userRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(CreateTransactionDto $createTransactionDto): bool
    {
        return $this->canTransact($createTransactionDto->value, $createTransactionDto->payer);
    }

    private function canTransact(float $value, int $payer): bool
    {
        $userEntity = $this->userRepository->getUserById($payer);

        return $userEntity->user_entity == User::CONSUMER ?
            $this->haveBalanceToTransact($value, $payer) :
            throw new UserCannotTransactException();
    }

    private function haveBalanceToTransact(float $transactionValue, int $payer): bool | float
    {
        $userAccount = $this->accountRepository->getAccountByUserId($payer);

        return $userAccount->balance < $transactionValue ?
            throw new InsufficientBalanceException() :
            true;
    }
}
