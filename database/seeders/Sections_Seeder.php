<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sections;

class Sections_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $section_detalis=[
            [
                'id'=>1,
                'name'=>'Food',
                'status'=>1,
            ],
            [
                'id'=>2,
                'name'=>'Accessories',
                'status'=>1,
            ],
            [
                'id'=>3,
                'name'=>'Colognes',
                'status'=>1,
            ],
            [
                'id'=>4,
                'name'=>'Designers',
                'status'=>1,
            ],
        ];
        Sections::insert($section_detalis);
    }
}
