<?php

namespace Tests\Unit\Services\AuthorizingService;

use App\Services\AuthorizingService\AuthorizingService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthorizingServiceTest extends TestCase
{
    public function testGetAuthorizer()
    {
        config(['services.authorizing-service.base_uri' => 'http://example.com']);
        $authorizingService = new AuthorizingService();

        Http::fake([
            'http://example.com' => Http::response('', 200)
        ]);

        $status = $authorizingService->getAuthorizer();
        $this->assertEquals(200, $status);
    }
}
