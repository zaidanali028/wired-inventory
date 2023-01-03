<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
class EmployeeModelFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $timezone= new DateTimeZone();



        // $tz=DateTime::setTimezone('Africa/Accra');
      
        $random_date = $this->faker->dateTimeThisYear;
        return [
            // 'id' => 1,
        'name' => $this->faker->name,
        'mobile' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'address' => $this->faker->address,
        'joining_date' =>$random_date->format('d/m/Y'),
        'salary' => $this->faker->numberBetween(600,1000),



    ];
    }
}
