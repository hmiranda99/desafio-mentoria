<?php

namespace App\Http\Requests;

use Spatie\LaravelData\Data;

class CreateTransactionDto extends Data
{
    public float $value;
    public int $payer;
    public int $payee;
    public string $type;

    public static function rules()
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|int|exists:users,id|different:payee',
            'payee' => 'required|int|exists:users,id',
            'type' => ['required', 'regex:/^P2[PB]$/']
        ];
    }

    public static function messages()
    {
        return [
            //value
            'value.required' => 'O valor da transação obrigatório.',
            'value.numeric' => 'O valor da transação precisa ser numérico.',
            //payer
            'payer.required' => 'O ID do pagador é obrigatório.',
            'payer.int' => 'O ID do pagador deve ser um número inteiro.',
            'payer.exists' => 'Este pagador não existe no banco de dados.',
            'payer.different' => 'O pagador deve ser diferente do recebedor.',
            //payee
            'payee.required' => 'O ID do recebedor é obrigatório.',
            'payee.int' => 'O ID do recebedor deve ser um número inteiro.',
            'payee.exists' => 'Este recebedor não existe no banco de dados.',
            //type
            'type.required' => 'Tipo de transação é obrigatório.',
            'type.regex' => 'Só fazemos transações do tipo P2P ou P2B.'
        ];
    }
}
