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
        //insert one admin record
        $admin_record=[
            // [
            //     'id'=>1,
            //     'name'=>'Zaidu Suppa',
            //     'type'=>'superadmin',

            //     'mobile'=>'+233240040834',
            //     'email'=>'adminzaid@amashop.com',
            //     'password'=>Hash::make('12345678'),
            //     'image'=>'',
            // 'status'=>1

            //     ],
            [
            'id'=>7,
            'name'=>'Employee 7',
            'type'=>'employee',
            // 'vendor_id'=>4,
            'mobile'=>'+233240040834',
            'email'=>'Z@yutamart.com',
            'password'=>Hash::make('60606060'),
            'image'=>'',
        'status'=>1

            ],
            [
                'id'=>8,
                'name'=>'Employee 8',
                'type'=>'employee',
                // 'vendor_id'=>4,
                'mobile'=>'+233240040834',
                'email'=>'superadgy@yutamart.com',
                'password'=>Hash::make('60606060'),
                'image'=>'',
            'status'=>1

                ],
        ];
        Admin::insert($admin_record);

    }
}
