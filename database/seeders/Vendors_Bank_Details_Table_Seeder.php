<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendors_Bank_Details;
class Vendors_Bank_Details_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $vendors_bank_details=[
            [
                'id'=>1,
                'vendor_id'=>1,
                'account_holder_name'=>'BABA ALI BANK ACC',
                'bank_name'=>"Barclays Ghana",
                'account_number'=>'4654535647268767',



            ]
        ];

        Vendors_Bank_Details::insert($vendors_bank_details);
    }
}
