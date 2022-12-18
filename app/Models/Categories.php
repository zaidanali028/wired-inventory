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





}
