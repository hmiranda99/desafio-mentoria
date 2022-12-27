<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountDto;

class AccountRepository
{
    /**
     * This method gets account by user id.
     * @param  int $userId
     * @return Response
     */
    public function getAccountByUserId(int $userId): AccountDto
    {
        $account = Account::where('user_id', 'LIKE', '%' . $userId . '%')->first();
        return $account ? new AccountDto($account->toArray()) : null;
    }

    /**
     * This method deletes account by user id.
     * @param  int $userId
     * @return Response
     */
    public function deleteAccountByUserId(int $userId): bool
    {
        return Account::where('user_id', 'LIKE', '%' . $userId . '%')->delete();
    }
}
