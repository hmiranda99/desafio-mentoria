<?php

namespace App\Helpers;

use App\Enums\OperationEnum;

class TransactionHelper
{
    public function withdrawOrAddBalance(OperationEnum $operation, $balance, $transactionValue)
    {
        return $operation == OperationEnum::ADD ?
            $balance + $transactionValue :
            $balance - $transactionValue;
    }
}
