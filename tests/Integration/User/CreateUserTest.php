<?php

namespace Tests\Integration\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Models\CreateUserDtoFactory;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldCreateUser()
    {
        $createUserDto = CreateUserDtoFactory::makeRealFactory([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);

        $response = $this->post('/api/user', $createUserDto->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => '41.698.459/0001-98'
        ]);
    }

    /** @dataProvider casesCnpj */
    public function testShouldCreateUserButCnpjFails($cnpj)
    {
        $createUserDto = CreateUserDtoFactory::makeRealFactory([
            'email' => 'email@email.com',
            'cpf' => '902.470.020-54',
            'cnpj' => $cnpj
        ]);
        $response = $this->post('/api/user', $createUserDto->toArray());
        $this->assertEquals('Não é um CNPJ válido, digite novamente', $response->exception->getMessage());
    }

    /** @dataProvider casesCpf */
    public function testShouldCreateUserButCpfFails($cpf)
    {
        $createUserDto = CreateUserDtoFactory::makeRealFactory([
            'email' => 'email@email.com',
            'cpf' => $cpf,
            'cnpj' => '41.698.459/0001-98'
        ]);
        $response = $this->post('/api/user', $createUserDto->toArray());
        $this->assertEquals('Não é um CPF válido, digite novamente.', $response->exception->getMessage());
    }

    public function casesCnpj(): array
    {
        return [
            'fail' => ['11.111.111/1111-11'],
            'dig-13' => ['12.345.678/0001-99'],
            'dig-12' => ['04.865.692/0001-75'],
            'error' => ['20.656.456/0001-1']
        ];
    }

    public function casesCpf(): array
    {
        return [
            'fail' => ['111.111.111-11'],
            'dig-10' => ['123.456.789-10'],
            'dig-9' => ['123.456.789-01'],
            'error' => ['902.470.020-5']
        ];
    }
}
