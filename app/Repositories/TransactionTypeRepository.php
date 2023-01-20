<?php

namespace App\Repositories;

use App\Enums\TransactionsTypesEnum;
use App\Models\TransactionType;

class TransactionTypeRepository
{
    public function getIdTransactionTypeByName(string $transactionType)
    {
        $type = TransactionType::where('description', 'LIKE', '%' . $transactionType . '%')->first();
        return $type->id;
    }
}
