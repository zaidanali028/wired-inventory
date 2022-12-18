<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cateogries as CateogriesModel;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class subCateogriesController extends Controller
{
    public function sub_categories(){
        Session::put('page','sub-categories');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();


        return view('admin.categories.sub-categories')->with(compact('admin_details'));


    }
}
