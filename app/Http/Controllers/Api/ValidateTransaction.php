<?php

namespace App\Http\Controllers\Api;

use App\Enums\TransactionsTypesEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;
use App\Http\Requests\CreateTransactionDto;
use App\Exceptions\UsersExceptions\UserCannotTransactException;
use App\Exceptions\TransactionsExceptions\InsufficientBalanceException;
use App\Exceptions\TransactionsExceptions\WrongTransactionTypeException;

class ValidateTransaction
{
    public function __construct(
        protected AccountRepository $accountRepository,
        protected UserRepository $userRepository
    ) {
    }

    /**
     * Start of validation.
     * @param CreateTransactionDto $createTransactionDto
     * @return bool
     */
    public function handle(CreateTransactionDto $createTransactionDto): bool
    {
        return $this->canTransact($createTransactionDto);
    }

    /**
     * Checks if user has permission to transact, only consumers can.
     * @param CreateTransactionDto $createTransactionDto
     * @return bool
     * @throws InsufficientBalanceException
     * @throws UserCannotTransactException
     * @throws WrongTransactionTypeException
     */
    private function canTransact(CreateTransactionDto $createTransactionDto): bool
    {
        $userEntityPayer = $this->userRepository->getUserById($createTransactionDto->payer);
        $userEntityPayee = $this->userRepository->getUserById($createTransactionDto->payee);

        if ($userEntityPayer->user_entity != User::CONSUMER) {
            throw new UserCannotTransactException();
        }

        if (
            $userEntityPayee->user_entity == User::CONSUMER &&
            $createTransactionDto->type == TransactionsTypesEnum::P2B->value
        ) {
            throw new WrongTransactionTypeException();
        }

        return $this->haveBalanceToTransact($createTransactionDto->value, $createTransactionDto->payer);
    }

    /**
     * Checks if the user has balance to transact.
     * @param float $transactionValue
     * @param int $payer
     * @return bool
     * @return float
     * @throws InsufficientBalanceException
     */
    private function haveBalanceToTransact(float $transactionValue, int $payer): bool
    {
        $userAccount = $this->accountRepository->getAccountByUserId($payer);

        return $userAccount->balance < $transactionValue ?
            throw new InsufficientBalanceException() :
            true;
    }
}
