<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VentasFactory extends Factory
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
            'account_id' => 1,
            'id_celular' => $this->faker->numberBetween(1, 10),
            'nombre_cliente' => $this->faker->name,
            'imei' => $this->faker->ean13(),
            'numero_celular_cliente' => $this->faker->phoneNumber(),
            'cc_cliente' => $this->faker->numberBetween(1, 100),
            'precio' => $this->faker->randomNumber(6),
            'fecha' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
