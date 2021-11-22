<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $limit = [10,20,25,30,40,50,75,100,150,200];
        $prices = [5000,10000,15000,20000,25000,30000,40000,50000,60000,75000,100000,125000,150000,175000,200000];
        return [
            'name' => $this->faker->unique()->words(rand(1,5), true),
            'code' => $this->faker->ean13(),
            'unit_id' => rand(1,10),
            'price' => $prices[rand(0,14)],
            'trigger_limit' => $limit[rand(0,9)]
        ];
    }
}
