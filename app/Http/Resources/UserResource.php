<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserDto;

class UserResource extends JsonResource
{
    /** @var UserDto */
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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'user_entity' => $this->resource->user_entity,
            'document' => [
                'cpf' => $this->resource->cpf ?? null,
                'cnpj' => $this->resource->cnpj ?? null
            ],
            'account' => $this->resource->account->toArray()
        ];
    }
}
