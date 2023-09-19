<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\CreateTransactionDto;
use Tests\TestCase;

class CreateTransactionDtoTest extends TestCase
{
    public function testCompareRules()
    {
        $expectedRules = [
            'value' => 'required|numeric',
            'payer' => 'required|int|exists:users,id|different:payee',
            'payee' => 'required|int|exists:users,id',
            'type' => ['required', 'regex:/^P2[PB]$/']
        ];

        $this->assertEquals($expectedRules, CreateTransactionDto::rules());
    }

    public function testCompareMessages()
    {
        $expectedMessages = [
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

        $this->assertEquals($expectedMessages, CreateTransactionDto::messages());
    }
}
