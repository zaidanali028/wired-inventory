<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Sections as SectionsModel;


class indexController extends Controller
{
    public function index(){
        $sections=SectionsModel::with(['get_category_hierarchy'])->get()->toArray();
        dd($sections);
        

        return view('front.index', ['site_name' => Session::get('site_name')]);


    }
}
