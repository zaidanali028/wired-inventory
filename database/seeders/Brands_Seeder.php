<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brands;

class Brands_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand_records=[
            [
                'id'=>1,
                'name'=>'Gucci',
                'status'=>0,
            ],
            [
                'id'=>2,
                'name'=>'Jordan',
                'status'=>1,
            ],
            [
                'id'=>3,
                'name'=>'Adidas',
                'status'=>1,
            ],
            [
                'id'=>4,
                'name'=>'Louis Vuitton',
                'status'=>1,
            ],
            [
                'id'=>5,
                'name'=>'Fendi ',
                'status'=>1,
            ],
        ];
        Brands::insert($brand_records);
    }
}
