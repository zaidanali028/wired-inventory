<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
    //    $this->call(admins_table_seeder::class);
        // $this->call(vendors_table_seeder::class);
        // $this->call(vendors_table_seeder::class);
        // $this->call(Vendors_Business_Details_Table_Seeder::class);
        //  $this->call(Vendors_Bank_Details_Table_Seeder::class);
        //  $this->call(categories_table_seeder::class);
        // $this->call(Sections_Seeder::class);
        // $this->call(Brands_Seeder::class);
        $this->call(Products_Seeder::class);
        // $this->call(Product_Attributes_Table_Seeder::class);
        // $this->call(Employee_Seeder::class);



    }

}
