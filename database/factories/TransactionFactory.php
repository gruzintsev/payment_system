<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    protected static $availableCurrencies = ['RUB', 'USD', 'EUR'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_from_id' => $this->faker->numberBetween(1, 100),
            'user_to_id' => $this->faker->numberBetween(1, 100),
            'currency_iso' => static::$availableCurrencies[array_rand(static::$availableCurrencies)],
            'amount' => $this->faker->numberBetween(100, 1000),
            'status' => Transaction::STATUS_NEW,
        ];
    }
}
