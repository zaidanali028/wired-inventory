<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'salaries';

    function get_emp(){
        return $this->belongsTo(EmployeeModel::class,'employee_id','id');
    }

}
