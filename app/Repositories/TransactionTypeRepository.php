<?php

namespace App\Repositories;

use App\Models\TransactionType;

class TransactionTypeRepository
{
    /**
     * This method is responsible for getting the ID of the transaction type.
     * @param string $transactionType
     * @return int
     */
    public function getIdTransactionTypeByName(string $transactionType): int
    {
        $type = TransactionType::where('description', 'LIKE', '%' . $transactionType . '%')->first();
        return $type->id;
    }
}
