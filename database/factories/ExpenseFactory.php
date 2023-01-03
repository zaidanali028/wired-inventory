<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $random_date = $this->faker->dateTimeBetween('-2years','now');
        return [

            // 'id' => 1,
            'details' => $this->faker->unique()->paragraph,
            'expense_date' => $random_date->format('d/m/Y'),
            'created_at' => $random_date,
            'amount' => $this->faker->numberBetween(600, 5000),

        ];
    }
}
