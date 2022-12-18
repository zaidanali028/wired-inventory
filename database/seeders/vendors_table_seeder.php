<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor as VendorModel;
class vendors_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $vendor_records=[
        //   [
        //       'id'=>1,
        //       'name'=>'Ali Usman Zaidan',
        //       'address'=>'plot 22 blk T',
        //       'digital_address'=>'AK-317-1453',
        //       'city'=>'Kumasi',
        //       'state'=>'Ashanti',
        //       'country'=>'Ghana',


        //       'mobile'=>'+233244968219',
        //       'email'=>'zaidanli2028@gmail.com',
        //     //  'password'=>'$2y$10$jlBAMHqUVxb0MiMzmu.ede/1shEEEHYXpGqdx88VQVLJ2uHI/rIsS',
        //       'status'=>0
        //   ],
          [
            'id'=>3,
            'name'=>'Vendor 3',
            'address'=>'plot 22 blk T',
            'digital_address'=>'AK-317-1453',
            'city'=>'Kumasi',
            'state'=>'Ashanti',
            'country'=>'Ghana',


            'mobile'=>'+233244968219',
            'email'=>'zaidacxnli3028@gmail.com',
          //  'password'=>'$2y$10$jlBAMHqUVxb0MiMzmu.ede/1shEEEHYXpGqdx88VQVLJ2uHI/rIsS',
            'status'=>0
        ],
        // [
        //     'id'=>4,
        //     'name'=>'Vendor 3',
        //     'address'=>'plot 22 blk T',
        //     'digital_address'=>'AK-317-1453',
        //     'city'=>'Kumasi',
        //     'state'=>'Ashanti',
        //     'country'=>'Ghana',


        //     'mobile'=>'+233244968219',
        //     'email'=>'zaizdgfdanli4028@gmail.com',
        //   //  'password'=>'$2y$10$jlBAMHqUVxb0MiMzmu.ede/1shEEEHYXpGqdx88VQVLJ2uHI/rIsS',
        //     'status'=>0
        // ],
        ];
        VendorModel::insert($vendor_records);


    }
}
