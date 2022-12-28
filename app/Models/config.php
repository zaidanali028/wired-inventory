<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    use HasFactory;
    protected $table='config';
    protected $fillable = [
        'shop_logo','shop_tin_number','shop_email'
        ,'shop_location','shop_address','shop_number',
        'shop_name'
    ];

}
