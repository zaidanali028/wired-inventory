<?php


namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();


        return view('admin.products.products')->with(compact('admin_details'));


    }
}
