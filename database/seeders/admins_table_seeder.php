<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class admins_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $admin_record=
        [
                'id'=>80,
                'name'=>'Employee 8',
                'type'=>'empoyee',
                // 'vendor_id'=>4,
                'mobile'=>'+233240040834',
                'email'=>'z@yutamart.com',
                'password'=>Hash::make('12345678'),
                'photo'=>'',
            'status'=>1

     ];
        //insert one admin record
        Admin::insert($admin_record);

        // insert datat using adminfactory
        // Admin::factory()->times(80)->create();

    }
}
