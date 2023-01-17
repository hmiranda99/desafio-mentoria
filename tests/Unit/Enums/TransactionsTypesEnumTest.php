<?php

namespace Tests\Unit\Enums;

use App\Enums\TransactionsTypesEnum;
use Tests\TestCase;

class TransactionsTypesEnumTest extends TestCase
{
    public function testEnum()
    {
        $this->assertEquals('P2P', TransactionsTypesEnum::P2P->value);
        $this->assertEquals('P2B', TransactionsTypesEnum::P2B->value);
    }
}