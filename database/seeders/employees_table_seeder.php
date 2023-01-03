<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeModel;
use App\Models\Admin as AdminModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
class employees_table_seeder extends Seeder
{
   protected $constant_amount=500;
//    protected $random_date = $this->faker->dateTime($end_date, $start_date);


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        AdminModel::factory()->times($this->constant_amount)->create()
        // relational seeding using factories(kvngthr!v3)(1 ADMIN(TYPE==EMPLOYEE) 1-EMPLOYEE
        ->each(function($admin){
            EmployeeModel::factory()->create([
                'emplyee_id'=>$admin->id,
              ]);
             });

    }
}
