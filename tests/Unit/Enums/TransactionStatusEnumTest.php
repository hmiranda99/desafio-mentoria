<?php

namespace Tests\Unit\Enums;

use App\Enums\TransactionStatusEnum;
use Tests\TestCase;

class TransactionStatusEnumTest extends TestCase
{
    public function testEnum()
    {
        $this->assertEquals('AUT', TransactionStatusEnum::AUT->value);
        $this->assertEquals('CAP', TransactionStatusEnum::CAP->value);
        $this->assertEquals('NOT', TransactionStatusEnum::NOT->value);
        $this->assertEquals('ERR', TransactionStatusEnum::ERR->value);
    }
}