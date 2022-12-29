<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(2),
            'number' => $this->faker->numerify('#########'),
            'balance' => $this->faker->randomFloat(2, 100, 200),
            'user_id' => $this->faker->unique()->randomNumber(2)
        ];
    }
}
