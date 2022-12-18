<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Auth;
class brandsController extends Controller
{
    public function brands(){
        Session::put('page','brands');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();



        return view('admin.brands.brands')->with(compact('admin_details'));


    }
}
