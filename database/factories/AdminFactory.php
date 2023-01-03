<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type=['superadmin','employee'];

        $status=[0,1];
        return [
            // 'id' => 1,
        'name' => $this->faker->unique()->name,
        'type' => $this->faker->randomElement($type),
        'mobile' => $this->faker->unique()->phoneNumber,
        'email' => $this->faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'photo' => '',
        'status' => $this->faker->randomElement($status)
    ];
    }
}
