<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GastosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id' => $this->faker->numberBetween(1, 6),
            'account_id' => $this->faker->numberBetween(1, 6),
            'motivo' => $this->faker->word(),
            'cantidad' => $this->faker->numberBetween(100, 1000),
            'fecha' => now(),
        ];
    }
}
