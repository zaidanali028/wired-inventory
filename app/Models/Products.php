<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    // use HasFactory;


    protected $fillable = ['product_name',
    'product_color',
    'section_id',
    'category_id',
    'product_weight',
    'product_description',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'is_featured',
    'status',
    'product_price',
    'product_discount',
    'brand_id',
    'vendor_id',
    'admin_type',
    'product_slug',
    'product_video',
    'admin_id'
];

    protected $table = 'products';

    public function get_vendor_details(){
        return $this->belongsTo('App\Models\vendor','vendor_id','id');


    }
    public function get_product_section(){
        return $this->belongsTo('App\Models\Sections','section_id','id');
        // ->select('name');

    }
    public function get_product_category(){
        return $this->belongsTo('App\Models\Categories','category_id','id');
        // ->select('category_name');
    }
    public function get_product_brand(){
        return $this->belongsTo('App\Models\Brands','brand_id','id');
        // ->select('category_name');
    }
    public function product_imgs(){
        return $this->hasMany('App\Models\ProductsGallery','product_id','id');
     }





  
}
