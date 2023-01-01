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
    pub

    public function get_issued_admin(){
        return $this->belongsTo('App\Models\Admin','issued_by','id');
    }
    public function get_order_detail(){
        return $this->hasMany('App\Models\OrderDetails','order_id','id')->with('product_details');
    }


}
