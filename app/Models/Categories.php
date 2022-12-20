<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table='categories';
    protected $fillable = [

    'category_name',

    'status'];

    use HasFactory;
    // Kvngthr!v3

    public function get_products(){
        return $this->hasMany('App\Models\Products','category_id','id');
        // ->select('name');

    }





}
