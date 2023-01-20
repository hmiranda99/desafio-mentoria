<?php

namespace Tests\Unit\Enums;

use App\Enums\OperationEnum;
use Tests\TestCase;

class OperationEnumTest extends TestCase
{
    public function testEnum()
    {
        $this->assertEquals('add', OperationEnum::ADD->value);
        $this->assertEquals('sub', OperationEnum::SUB->value);
    }
}