<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
class Pos extends Model
{
    use HasFactory;
    protected $table = 'pos';
        // Add the fields that should be mass-assignable
        protected $fillable = [
            'product_id',
            'product_name',
            'product_quantity',
            'product_price',
            'sub_total',
        ];

         // Define the relationship with the ProductsModel
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    // Optionally, you can define an accessor to get the stock
    public function getStockAttribute()
    {
        return $this->product->product_quantity ?? 0;  // Default to 0 if no stock
    }


}
