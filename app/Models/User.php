<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BinCodeFactory
 * @package Database\Factories
 * @method BinCode|BinCode[]|Collection create($attributes = [], ?Model $parent = null)
 * @method BinCode createOne($attributes = [])
 * @method BinCode|BinCode[]|Collection make($attributes = [], ?Model $parent = null)
 * @method BinCode makeOne($attributes = [])
*/
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
} 