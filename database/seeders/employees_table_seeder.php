<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeModel;
use App\Models\Admin as AdminModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
class employees_table_seeder extends Seeder
{
   protected $constant_amount=200;
//    protected $random_date = $this->faker->dateTime($end_date, $start_date);


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // AdminModel::factory($this->constant_amount)->create()
        // ->each(function($admin){
            EmployeeModel::factory()->times(1)->create([
                'emplyee_id'=>'1',
              ]);


        // });

    }
}
