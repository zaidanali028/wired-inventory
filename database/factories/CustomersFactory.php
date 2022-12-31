<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type=['superadmin','employee'];
                    // name,email,phone,address,photo


        $status=[0,1];
        return [
            // 'id' => 1,
        'name' => $this->faker->name,
        'phone' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'address' => $this->faker->address,
        'photo' => $this->faker->imageUrl(),
    ];
    }
}
