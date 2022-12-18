<?php

namespace Database\Seeders;
use App\Models\ProductAttributes;


use Illuminate\Database\Seeder;

class Product_Attributes_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prd_attrs=[
            [
                'id'=>1 ,
                'product_id'=>66,
                'price'=>89,
                'size'=>   10,
                'stock'=>700,
                'status'=>1,
            ]
        ];
    ProductAttributes::insert($prd_attrs);

    }



}
