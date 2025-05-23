<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->integer('category_id');
            $table->string('product_name');
            $table->string('product_quantity');
            $table->string('selling_price');


            $table->string('product_code')->nullable();
            $table->string('supplier_id')->nullable();

            $table->string('buying_price')->nullable();

            $table->string('image')->nullable();
            $table->string('uploaded_by')->nullable();

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
        Schema::dropIfExists('products');
    }
}

