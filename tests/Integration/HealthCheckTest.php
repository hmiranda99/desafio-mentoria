<?php

namespace Tests\Integration;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function testHealthCheckRoute()
    {
        $response = $this->get('/api/check');
        $response->assertStatus(200);
    }
}