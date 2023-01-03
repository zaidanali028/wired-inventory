<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [


            'product_name' => $this->faker->name,
            'product_quantity' => $this->faker->numberBetween(600, 1000),
            'selling_price' => $this->faker->numberBetween(900, 5000),
            'buying_price' => $this->faker->numberBetween(900, 3000),
            'image' => '',
            // 'image' => $this->faker->image(storage_path('public/storage/product_imgs'),300,300),


        ];
    }
}
