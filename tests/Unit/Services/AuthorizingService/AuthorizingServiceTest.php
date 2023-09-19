<?php

namespace Tests\Unit\Services\AuthorizingService;

use App\Services\AuthorizingService\AuthorizingService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthorizingServiceTest extends TestCase
{
    public function testGetAuthorizer()
    {
        $url = 'https://exemplo.com/api/mock';

        Http::fake([
            $url => Http::response([], 200)
        ]);

        $authorizingService = new AuthorizingService($url);
        $statusCode = $authorizingService->getAuthorizer();
        $this->assertEquals(200, $statusCode);
    }
}
