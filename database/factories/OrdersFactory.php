<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    /*
    $table->integer('customer_id');
    $table->string('payBy');
    $table->string('pay');
    $table->string('due');
    $table->string('discount');

    $table->bigInteger('qty');
    $table->bigInteger('sub_total');
    $table->integer('vat');
    $table->bigInteger('total');
    $table->string('order_date');
    $table->string('order_month');
    $table->string('order_year');
    $table->string('day');
     */
    public function definition()
    {
        $random_date = $this->faker->dateTimeBetween('-2years', 'now');
        $random_year=['2021','2022'];
        $by = ['Cheque', 'Hand Cash', 'Momo Transfer'];
        $random_mnth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return [

            'payBy' => $this->faker->randomElement($by),
            'pay' => $this->faker->numberBetween(20, 50),
            'created_at' => $random_date,
            'pay' => $this->faker->numberBetween(50, 100),
            'qty' => 1,
            'due' => $this->faker->numberBetween(50, 100),
            'discount' => $this->faker->numberBetween(10, 20),
            'vat' => 0,
            'discount' => $this->faker->numberBetween(5, 20),
            'sub_total' => $this->faker->numberBetween(15, 180),
            'total' => $this->faker->numberBetween(15, 80),
            'order_month' => $this->faker->randomElement($random_mnth),
            'order_year' =>  $this->faker->randomElement($random_year),
            'order_date' => $random_date->format('d/m/Y'),
            'day' =>0,

        ];
    }
}
