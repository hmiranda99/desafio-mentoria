<?php

namespace Tests\Unit\Adapters;

use App\Adapters\UserDtoAdapter;
use Tests\TestCase;
use App\Models\UserDto;
use Tests\Unit\Models\UserDtoFactory;

class UserDtoAdapterTest extends TestCase
{
    public function testAdaptWithArray()
    {
        $userDto = UserDtoFactory::makeRealFactory();
        $userDto->account = null;

        $instance = new UserDtoAdapter();
        $response = $instance->adapter($userDto, null, $userDto->id);

        $this->assertInstanceOf(UserDto::class, $response);
        $this->assertEquals($userDto, $response);
    }
}
