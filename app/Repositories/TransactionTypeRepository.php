<?php

namespace App\Repositories;

use App\Enums\TransactionsTypesEnum;
use App\Models\TransactionType;

class TransactionTypeRepository
{
    public function getIdTransactionTypeByName(TransactionsTypesEnum $transactionType)
    {
        $type = TransactionType::where('description', 'LIKE', '%' . $transactionType->value . '%')->first();
        return $type->id;
    }
}
