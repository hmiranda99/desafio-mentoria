<?php

namespace App\Helpers;

use App\Models\User;
use App\Enums\OperationEnum;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;

class TransactionHelper
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

    public function createHashTransaction()
    {
        return sha1(time());
    }

    public function withdrawOrAddBalance(OperationEnum $operation, $balance, $transactionValue)
    {
        return $operation == OperationEnum::ADD ?
            $balance + $transactionValue :
            $balance - $transactionValue;
    }

    public function canTransact(int $payer): bool
    {
        $userEntity = $this->userRepository->getUserById($payer);

        return $userEntity->user_entity == User::CONSUMER ?? false;
    }

    public function haveBalanceToTransact(float $transactionValue, int $payer): bool | float
    {
        $userAccount = $this->accountRepository->getAccountByUserId($payer);

        if (is_null($newBalanceAccount = $this->userHasBalance($transactionValue, $userAccount->balance))) {
            return false;
        }

        return $this->accountRepository->updateBalanceAccount($newBalanceAccount, $payer);
    }

    private function userHasBalance(float $transactionValue, float $userBalance): ?float
    {
        if ($userBalance < $transactionValue) {
            return null;
        }

        return $this->withdrawOrAddBalance(OperationEnum::SUB, $userBalance, $transactionValue);
    }

    public function prepareAddBalance(int $user, int $transactionValue)
    {
        $account = $this->accountRepository->getAccountByUserId($user);
        $newBalance = $this->withdrawOrAddBalance(OperationEnum::ADD, $account->balance, $transactionValue);
        return $this->accountRepository->updateBalanceAccount($newBalance, $user);
    }
}
