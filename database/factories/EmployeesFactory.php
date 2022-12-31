<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
class EmployeesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {



        $start_date = new DateTime('-1 year');
        $end_date = new DateTime('+1 year');
        $random_date = $this->faker->dateTime($end_date, $start_date);
        return [
            // 'id' => 1,
        'name' => $this->faker->name,
        'phone' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'address' => $this->faker->address,
        'joining_date' =>$random_date->format('d/m/Y'),
        'salary' => $this->faker->numberBetween(600,1000),
        'photo' => '',


    ];
    }
}
