<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {





        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('payBy');
            $table->string('pay');
            $table->string('due');
            $table->string('discount');

            $table->bigInteger('qty');
            $table->bigInteger('sub_total');
            $table->integer('vat');
            $table->bigInteger('total');
            $table->string('order_date');
            $table->string('order_month');
            $table->string('order_year');
            $table->string('day');
            
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
        Schema::dropIfExists('orders');
    }
}
