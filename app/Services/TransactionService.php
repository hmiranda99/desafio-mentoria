<?php

namespace App\Services;

use Fig\Http\Message\StatusCodeInterface;
use App\Services\ServiceAuthorizer\ServiceAuthorizer;
use App\Exceptions\ServicesExceptions\ServiceDownException;

class TransactionService
{
    protected $serviceAuthorizer;

    public function __construct(ServiceAuthorizer $serviceAuthorizer)
    {
        $this->serviceAuthorizer = $serviceAuthorizer;
    }

    public function authorizeService()
    {
        $serviceAuthorizer = $this->serviceAuthorizer->getAuthorizer();
        return $this->checkAuthorizer($serviceAuthorizer);
    }

    private function checkAuthorizer(int $statusCode)
    {
        if ($statusCode == StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR) {
            return throw new ServiceDownException();
        }

        if (
            $statusCode != StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR &&
            $statusCode != StatusCodeInterface::STATUS_OK
        ) {
            return false;
        }

        return true;
    }
}
