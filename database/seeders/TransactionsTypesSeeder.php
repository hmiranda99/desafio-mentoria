<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionType;

class TransactionsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::insert([
            [
                'description' => 'Transação',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'description' => 'PIX',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'description' => 'TED',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'description' => 'Transação',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'description' => 'Transação',
                'created_at' => '2022-04-07 11:19:02',
            ],
            [
                'description' => 'Transação',
                'created_at' => '2022-04-07 11:19:02',
            ],
        ]);
    }
}
