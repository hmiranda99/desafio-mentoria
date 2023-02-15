<?php

namespace Tests\Unit\Enums;

use App\Enums\TransactionStatusEnum;
use Tests\TestCase;

class TransactionStatusEnumTest extends TestCase
{
    public function testEnum()
    {
        $this->assertEquals('Authorized', TransactionStatusEnum::AUT->value);
        $this->assertEquals('Not completed', TransactionStatusEnum::NOT->value);
    }
}