<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarcasFactory extends Factory
{
    private $marcas = [
        'Apple',
        'Samsung',
        'Xiaomi',
        'Huawei',
        'Oppo',
        'Motorola',
        'Nokia',
        'LG',
        'Alcatel',
        'ZTE',
    ];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->unique()->randomElement($this->marcas),
            'account_id' => 1,
        ];
    }
}
