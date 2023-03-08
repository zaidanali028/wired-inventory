<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Seeder;

class products_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Categories::factory()->times(17)->create()
        // relational seeding using factories(kvngthr!v3)(1 ADMIN(TYPE==EMPLOYEE) 1-EMPLOYEE
            ->each(function ($category) {
                Products::factory()->times(685)->create([
                    'category_id' => $category->id,

                ]);
            });
    }
}