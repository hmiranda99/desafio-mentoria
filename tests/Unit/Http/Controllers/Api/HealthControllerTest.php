<?php

namespace Tests\Unit\Http\Controllers\Api;

use Tests\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Controllers\Api\HealthController;

class HealthControllerTest extends TestCase
{
    public function testHealthCheck()
    {
        $instance = new HealthController();
        $response = $instance->check();
        
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->status());
    }
}
