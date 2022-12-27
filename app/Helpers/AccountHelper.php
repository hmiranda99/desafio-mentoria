<?php

namespace App\Helpers;

class AccountHelper
{

    /**
     * This method organizes the array for inserting data into the database.
     * @return array
     */
    public function accountUserData(): array
    {
        return [
            'number' => $this->randomNumberAccount(),
            'balance' => $this->randomBalanceAccount()
        ];
    }

    /**
     * This method create the account number for the user.
     * @return string
     */
    private function randomNumberAccount(): string
    {
        return substr_replace(strval(rand()), '-', -1, 0);
    }

    /**
     * This method create an initial value for the user account.
     * @return float
     */
    private function randomBalanceAccount(): float
    {
        return mt_rand(100 * 10, 200 * 10) / 10;
    }
}
