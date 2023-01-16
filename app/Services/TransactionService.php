<?php

namespace App\Services;

use App\Services\ServiceAuthorizer\AuthorizerService;

class TransactionService
{
    protected $serviceAuthorizer;

    public function __construct(
        AuthorizerService $serviceAuthorizer
    ) {
        $this->serviceAuthorizer = $serviceAuthorizer;
    }

    public function authorizeService()
    {
        return $this->serviceAuthorizer->checkAuthorizer();
    }
}
