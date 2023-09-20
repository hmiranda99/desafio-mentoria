<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'user_entity' => 'string',
        'cpf' => 'string',
        'cnpj' => 'string'
    ];

    public const CONSUMER = 'consumer';
    public const SELLER = 'seller';

    public function account(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Account::class);
    }
}
