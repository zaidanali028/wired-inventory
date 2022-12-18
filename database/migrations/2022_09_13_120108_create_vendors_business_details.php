<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsBusinessDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_business_details', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('shop_name');
            $table->string('shop_address');
            $table->string('shop_city');
            $table->string('shop_state');
            $table->string('shop_country');

            $table->string('shop_mobile');
            $table->string('shop_website');
            $table->string('shop_email');
            $table->string('shop_address_proof');
            $table->string('shop_address_proof_image');
            $table->string('shop_license_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors_business_details');
    }
}
