<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     *
     */
    /* $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('product_quantity')->nullable();
            $table->string('product_price')->nullable();
            $table->string('sub_total')->nullable(); */
    public function definition()
    {
        return [

            'sub_total' => $this->faker->numberBetween(15, 170),


        ];
    }
}
