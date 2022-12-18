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
        ['id'=>2,
        'section_id'=>27,
        'category_id'=>2,
        'brand_id'=>1,
        'vendor_id'=>3,
        'admin_type'=>'vendor',
        'admin_id'=>3,
        'product_name'=>'new stuff',
        'product_slug'=>""
        ,'product_color'=>'red',
        'product_price'=>3254,
        'product_discount'=>15,
        'product_weight'=>12,
        'product_video'=>'',
        'meta_title'=>"",
        'meta_description'=>"",
        'meta_keywords'=>"",
        'is_featured'=>1,
        'status'=>1,
        'product_description'=>"Just something for the big boys"
        ]












       ];


    //    looping all reocords
     foreach($product_records as $index=>$product){

    //    creating a slug with a record's product;s name
        $create_slug=Str::slug($product_records[$index]['product_name'],'-');
        // checking if this created slug already exsists
        $slug_exists=Products::where('product_slug', $create_slug)->exists();
        // if it does,add its id to prevent duplicate slug
        $create_slug=$slug_exists==true?$create_slug.'-'.$product_records[$index]['id']:$create_slug;
    //    assign it to the current record's product_slug
        $product_records[$index]['product_slug']=$create_slug;
        Products::insert($product_records);

     }

    }
}
