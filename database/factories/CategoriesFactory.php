<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $type=['superadmin','employee'];

        $status=[0,1];
        return [
            // 'id' => 1,
        'category_name' => $this->faker->name,

        'status' => $this->faker->randomElement($status)
    ];
    }
}
