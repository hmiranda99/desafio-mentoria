<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Letícia Betina Luzia Cavalcanti',
                'email' => 'leticiabetinacavalcanti@geniustyres.com.br',
                'password' => 'BwSZWAIU8h',
                'cpf' => null,
                'cnpj' => '54.674.564/0001-39',
                'user_entity' => 'seller',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'name' => 'Cauã Igor Marcos Vinicius Rocha',
                'email' => 'caua-rocha87@igui.com.br',
                'password' => '7mJLzNajYN',
                'cpf' => '271.846.355-40',
                'cnpj' => null,
                'user_entity' => 'consumer',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'name' => 'Guilherme Giovanni Rezende',
                'email' => 'guilherme-rezende97@ativacofres.com.br',
                'password' => 'TtepczjKmH',
                'cpf' => null,
                'cnpj' => '93.093.375/0001-24',
                'user_entity' => 'seller',
                'created_at' => '2022-04-07 11:19:02'
            ],
            [
                'name' => 'Tânia Raquel Souza',
                'email' => 'tania_souza@hotmail.fr',
                'password' => 'SMeCSnAHWA',
                'cnpj' => null,
                'cpf' => '799.353.495-00',
                'user_entity' => 'consumer',
                'created_at' => '2022-04-07 11:19:02'
            ],
        ]);
    }
}
