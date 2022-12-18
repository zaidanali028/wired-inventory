<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = ['name','email','phone','address','salary','photo','national_id','joining_date'];


}
