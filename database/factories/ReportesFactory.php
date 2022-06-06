<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportesFactory extends Factory
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
            'fecha' => $this->faker->date(),
            'user_id' => $this->faker->numberBetween(1, 6),
            'total' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
