<?php

namespace App\Models;

use Spatie\DataTransferObject\DataTransferObject;

class AccountDto extends DataTransferObject
{
    public int $id;
    public string $number;
    public float $balance;
}
