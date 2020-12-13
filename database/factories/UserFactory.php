<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    protected static $availableCurrencies = ['RUB', 'USD', 'EUR'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'country' => Str::substr($this->faker->country, 0, 20),
            'city' => $this->faker->city,
            'currency_iso' => static::$availableCurrencies[array_rand(static::$availableCurrencies)],
            'balance' => $this->faker->numberBetween(1000, 10000),
            'password' => $this->faker->password,
        ];
    }
}
