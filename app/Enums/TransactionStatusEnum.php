<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case AUT = 'Authorized';
    case NOT = 'Not completed';
}
