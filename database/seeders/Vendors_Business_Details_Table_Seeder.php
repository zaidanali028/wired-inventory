<?php

namespace Database\Seeders;
use App\Models\Vendors_Business_Details;
use Illuminate\Database\Seeder;


class Vendors_Business_Details_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors_bus_details=[
            [
                'id'=>1,
                'vendor_id'=>1,
                'shop_name'=>'ALI\'s FITTING SHOP',


                'vendor_id'=>1,
                'shop_address'=>'AK-317-1616',
                'shop_city'=>'KUMASI',
                'shop_state'=>'Ashanti',
                'shop_country'=>'Ghana',
                'shop_mobile'=>'+233256756834',
                'shop_website'=>'www.tarb-gh.com',
                'shop_email'=>'ali.shop@tarb-gh.com',
                'shop_address_proof'=>'Ghana Card',
                'shop_address_proof_image'=>'admin/images/dynamic_images/kingThrivex_417661020048.jpeg',
                'shop_license_number'=>'CX-RKHOD34'

            ]
        ];

        Vendors_Business_Details::insert($vendors_bus_details);
    }
}
