<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class Products_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $product_records=[
        ['id'=>1,
        'supplier_id'=>27,
        'category_id'=>2,
        'product_name'=>'new stuff',
        'product_quantity'=>1,
        'selling_price'=>'4354',
        'buying_price'=>'4354',
        'product_code'=>'gfh-fd',
       ],
       ['id'=>2,
       'supplier_id'=>27,
       'category_id'=>2,
       'product_name'=>'new stuff',
       'product_quantity'=>1,
       'selling_price'=>'4354',
       'buying_price'=>'4354',
       'product_code'=>'gfh-fd',
        ]
,
['id'=>3,
'supplier_id'=>27,
'category_id'=>2,
'product_name'=>'new stuff',
'product_quantity'=>1,
'selling_price'=>'4354',
'buying_price'=>'4354',
'product_code'=>'gfh-fd',
 ]











       ];
       Products::insert($product_records);


    }
}
