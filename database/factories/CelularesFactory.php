<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CelularesFactory extends Factory
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
            'marca_id' => $this->faker->numberBetween(1, 10),
            'modelo' => $this->faker->word(),
            'precio' => $this->faker->randomFloat(2, 0, 100),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
