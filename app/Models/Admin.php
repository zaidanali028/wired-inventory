<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//making this model authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\App;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admins';
    protected $guard = 'admin';
    protected $fillable = [
        'status','photo','password','email','mobile',
        'type','name'
    ];

    // protected static function newFactory()
    // {
    //     return \Database\Factories\AdminFactory::new();
    // }

    public function get_vendor_details_from_admin()
    {
        return $this->belongsTo('App\Models\vendor', 'vendor_id', 'id');
    }
    public function get_vendor_business_details_from_admin()
    {
        return $this->belongsTo(Vendors_Business_Details::class, 'vendor_id', 'vendor_id');
    }

    public function get_vendor_bank_details_from_admin()
    {
        return $this->belongsTo(Vendors_Bank_Details::class, 'vendor_id', 'vendor_id');
    }
}
