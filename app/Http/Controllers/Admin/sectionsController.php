<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sections as SectionsModel;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class sectionsController extends Controller
{

// this conroller is now a livewire component
    public function sections(){
        Session::put('page','sections');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();



        return view('admin.sections.sections')->with(compact('admin_details'));


    }

}
