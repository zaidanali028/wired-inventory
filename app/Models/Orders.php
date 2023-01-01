<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function get_customer(){
        return $this->belongsTo('App\Models\Customers','customer_id','id');
    }
    public function getEmployeeItemSoldQty($emloyee_admin_id,$query_today=false){
        // employee_item_sold_gty
        $today = date('d/m/Y');

        $employee_sale_cout=$query_today==true?Orders::where('order_date',$today)->where('issued_by',$emloyee_admin_id)->sum('qty'):Orders::where('issued_by',$emloyee_admin_id)->sum('qty');
        return $employee_sale_cout;

    }

    public function getEmployeeSaleWorth($emloyee_admin_id,$query_today=false){
        // employee_item_sold_gty
        $today = date('d/m/Y');

        $employee_sale_cout=$query_today==true?Orders::where('order_date',$today)->where('issued_by',$emloyee_admin_id)->sum('total'):Orders::where('issued_by',$emloyee_admin_id)->sum('total');
        return $employee_sale_cout;

    }
    public function get_issued_admin(){
        return $this->belongsTo('App\Models\Admin','issued_by','id');
    }
    public function get_order_detail(){
        return $this->hasMany('App\Models\OrderDetails','order_id','id')->with('product_details');
    }


}
