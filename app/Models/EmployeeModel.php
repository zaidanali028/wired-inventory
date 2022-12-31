<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Database\Factories\EmployeesFactory;

class EmployeeModel extends Model
{
    use HasFactory;
    // static function newFactory()
    // {
    //     return \Database\Factories\EmployeesFactory::new();
    // }
    protected $table = 'employees';
    protected $fillable = ['name','email','phone','address','salary','photo','national_id','joining_date'];

    function get_employee_admin_data(){
        return $this->belongsTo(Admin::class,'emplyee_id','id');
        // employee_id is assigned when creating employee from admin(id)
    }


}
