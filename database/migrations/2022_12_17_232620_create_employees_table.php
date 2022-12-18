<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // $table->string('')
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->float('salary');
           
            $table->string('national_id')->nullable();
            $table->string('emplyee_id');
            // admin_id=employee_id
            $table->string('joining_date');
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
        Schema::dropIfExists('employees');
    }
}
