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

        // $this->call(admins_table_seeder::class);
        $this->call(products_table_seeder::class);

        //   $this->call(categories_table_seeder::class);
        //  $this->call(customers_table_seeder::class);
        //  $this->call(employees_table_seeder::class);
        //  $this->call(expense_table_seeder::class);
        //  $this->call(orders_table_seeder::class);

        // $this->call(vendors_table_seeder::class);
        // $this->call(vendors_table_seeder::class);
        // $this->call(Vendors_Business_Details_Table_Seeder::class);
        //  $this->call(Vendors_Bank_Details_Table_Seeder::class);

        // $this->call(Sections_Seeder::class);
        // $this->call(Brands_Seeder::class);
        // $this->call(Products_Seeder::class);
        // $this->call(Product_Attributes_Table_Seeder::class);
        // $this->call(Employee_Seeder::class);



    }

}