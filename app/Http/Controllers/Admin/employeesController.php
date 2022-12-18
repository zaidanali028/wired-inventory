<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin as AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class employeesController extends Controller
{
    public function employee_management(Request $request)
    {
        Session::put('page', 'employee-management');

        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('admin.employees.employee_management', ['admin_details' => $admin_details]);

    }
}
