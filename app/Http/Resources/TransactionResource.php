<?php

namespace App\Http\Resources;

use App\Http\Requests\CreateTransactionDto;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /** @var CreateTransactionDto */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param null $request
     * @return array
     */
    public function toArray($request = null): array
    {
        return [
            'value' => $this->resource->value,
            'payer' => $this->resource->payer,
            'payee' => $this->resource->payee,
            'type' => $this->resource->type
        ];
    }
}
