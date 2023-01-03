<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Customers;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Seeder;

class orders_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer= Customers::factory()->create()
        ->each(function($customer){
        $order=Orders::factory()->times(10)->create([
            'customer_id'=>$customer
        ])->each(function($order){
            $category=Categories::factory()->create();
            $product=Products::factory()->create(['category_id'=>$category->id]);
            OrderDetails::factory()->create([
                'product_id'=>$product->id,
                'product_quantity'=>$product->quantity,
                'product_price'=>$product->price
            ]);

        });



        });

    }
}
