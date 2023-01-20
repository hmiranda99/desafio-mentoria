<?php

namespace Database\Factories;

use App\Enums\TransactionsTypesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionType>
 */
class TransactionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(2),
            'description' => $this->faker->randomElement([
                TransactionsTypesEnum::P2P->value
            ])
        ];
    }
}
