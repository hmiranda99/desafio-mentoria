<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountDto;

class AccountRepository
{
    /**
     * This method gets account by user id.
     * @param  int $userId
     * @return AccountDto
     */
    public function getAccountByUserId(int $userId): ?AccountDto
    {
        $account = Account::where('user_id', 'LIKE', '%' . $userId . '%')->first();
        return $account ? new AccountDto($account->toArray()) : null;
    }

    /**
     * This method deletes account by user id.
     * @param  int $userId
     * @return bool
     */
    public function deleteAccountByUserId(int $userId): bool
    {
        return Account::where('user_id', 'LIKE', '%' . $userId . '%')->delete();
    }

    /**
     * This method update balance account by user id.
     * @param  float $balance
     * @param  int $userId
     * @return bool
     */
    public function updateBalanceAccount(float $balance, int $userId): bool
    {
        return Account::where('user_id', $userId)->update(['balance' => $balance]);
    }
}
