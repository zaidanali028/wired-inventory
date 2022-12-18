<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cateogries as CateogriesModel;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Auth;


class mainCateogriesController extends Controller
{
    public function main_categories(){
        Session::put('page','categories');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();


        return view('admin.categories.main-categories')->with(compact('admin_details'));


    }
}
