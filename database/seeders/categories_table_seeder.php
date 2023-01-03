<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\Products;

class categories_table_seeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $table->integer('parent_id');
    // $table->string('category_url');
    // $table->integer('section_id');
    // $table->string('category_name');
    // $table->string('category_image');
    // $table->float('category_discount');
    // $table->text('category_description');

    // // su columns
    // $table->string('meta_title');
    // $table->string('meta_description');
    // $table->string('meta_keywords');
    // $table->tinyInteger('status');
    $category_records=[
        ['id'=>1,
        'parent_id'=>0,
        'category_url'=>'baby food',
        'section_id'=>1,
        'category_name'=>'BABY FOOD',
        'category_image'=>'',
        'category_discount'=>0,
        'category_description'=>'Baby Food For The Big Infants :)',
        'meta_title'=>"",
        'meta_description'=>"",
        'meta_keywords'=>"",
        'status'=>1,


    ],
    ['id'=>2,
    'parent_id'=>1,
    'category_url'=>'cereals',
    'section_id'=>1,
    'category_name'=>'CEREALS',
    'category_image'=>'',
    'category_discount'=>0,
    'category_description'=>'CEREAL FOR AWESOME INFANTS:)',
    'meta_title'=>"",
    'meta_description'=>"",
    'meta_keywords'=>"",
    'status'=>1,


],[
    'id'=>3,
        'parent_id'=>0,
        'category_url'=>'mens designers',
        'section_id'=>4,
        'category_name'=>'MENS DESIGNERS',
        'category_image'=>'',
        'category_discount'=>0,
        'category_description'=>'Just For The BIG GUYS:)',
        'meta_title'=>"",
        'meta_description'=>"",
        'meta_keywords'=>"",
        'status'=>1,
],[
    'id'=>4,
        'parent_id'=>3,
        'category_url'=>'MEN BAGS',
        'section_id'=>4,
        'category_name'=>'men bags',
        'category_image'=>'',
        'category_discount'=>0,
        'category_description'=>'Bags For The BIG GUYS:)',
        'meta_title'=>"",
        'meta_description'=>"",
        'meta_keywords'=>"",
        'status'=>1,
]
        ];

        // Categories::insert($category_records);
        Categories::factory()->times(15)->create();


    }
}
