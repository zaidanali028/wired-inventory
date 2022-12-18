<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    protected $connection = "mysql";
    protected $table='product_attributes';
    protected $fillable = ['size','stock','price','status','product_id'];

    use HasFactory;
}
