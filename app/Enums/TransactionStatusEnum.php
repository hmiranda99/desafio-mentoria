<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case AUT = 'AUT';
    case CAP = 'CAP';
    case NOT = 'NOT';
    case ERR = 'ERR';
}
