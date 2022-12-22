<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\Vendor as VendorModel;
use App\Models\Vendors_Business_Details as VendorBusinessDetailsModel;
use App\Models\Vendors_Bank_Details as VendorBankDetailsModel;
use App\Models\Countries as CountriesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin as AdminModel;
use Nette\Utils\Image;
use Illuminate\Support\Facades\Session;

class adminController extends Controller
{


    public function pos(){
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        Session::put('page','pos');
  return view('admin.pos.pos-management',['admin_details'=>$admin_details]);

    }
    public function orders(){
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        Session::put('page','orders');
  return view('admin.pos.orders',['admin_details'=>$admin_details]);

    }
    public function dashboard()
    {
        // dd(Session::get('site_name'));
        Session::put('page','dashboard');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('admin.dash_board', ['admin_details' => $admin_details]);
    }


    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();


            //custom valiation msg
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|min:8'
            ];
            $customMsgs = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
                'password.min' => 'Password can not be less than 8 characters'
            ];
            $this->validate($request, $rules, $customMsgs);


            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                return redirect('/admin/dashboard');
            } else {
                return back()->with('error_msg', "Invalid Email/Password");
            }
        }

        // echo Hash::make('45567dfdfhtt25ri1!');die;
        return view('admin.login',);
    }



    public function check_current_password(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            //if client password matches authenticated password
            return 'true';
        } else {
            return 'false';
        }
    }

    public function update_details(Request $request)
    {
        Session::put('page','update-details');

        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // if ($request->isMethod('post')) {
        // dd($request->file('profile_img'));

        //     $data = $request->all();
        //     $rules = [
        //         'name' => 'required|regex:/^[\pL\s\-]+$/u',
        //         'mobile' => 'required'
        //     ];

        //     $validated = $request->validate($rules);
        //     if ($request->hasFile('profile_img')) {
        //         $img_tmp = $request->file('profile_img');
        //         if ($img_tmp->isValid()) {
        //             $file_ext = $img_tmp->getClientOriginalExtension();

        //             $img_name = $admin_details['name'] . '_' . rand(101, 999999999999) . '.' . $file_ext;
        //             $img_path = 'admin/images/dynamic_images/' . $img_name;
        //             //echo  $img_path; die;
        //             Image::fromFile($img_tmp)->save($img_path);

        //             //updating user details[with a picture]
        //             AdminModel::where('id', Auth::guard('admin')->user()->id)->update(['image' => $img_name, 'name' => $data['name'], 'email' => $data['email'], 'mobile' => $data['mobile']]);
        //         }
        //     } else {
        //         //updating admin details[without image]
        //         AdminModel::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['name'], 'email' => $data['email'], 'mobile' => $data['mobile']]);
        //     }


        //     return back()->with("success_msg", 'Updated Admin Details Successfully!');
        // }

        return view('admin.settings.update_details', ['admin_details' => $admin_details]);
    }



    public function update_password(Request $request)
    {


        Session::put('page','update-password');
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();



        return view('admin.settings.update_password', ['admin_details' => $admin_details]);
    }


    public function admin_management()
    {
       $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
       Session::put('page','admin-management');
 return view('admin.admins.admin-management',['admin_details'=>$admin_details]);

    }
    public function customers_management(){
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        Session::put('page','customers-management');
 return view('admin.customers.customers-management',['admin_details'=>$admin_details]);


    }

    public function supplier_management(){
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        Session::put('page','supplier-management');
 return view('admin.suppliers.supplier-management',['admin_details'=>$admin_details]);


    }

    public function user_management($slug, Request $request)
    {
        if ($slug == 'users') {
            dd($slug);
        } elseif ($slug == 'subscribers') {
            dd($slug);
        }
    }

    public  function view_vendor_details(Request $request, $id)
    {
        $vendor_details = AdminModel::query();
        $vendor_details = $vendor_details->with('get_vendor_business_details_from_admin', 'get_vendor_details_from_admin', 'get_vendor_bank_details_from_admin')->where('id', $id)->first()->toArray();
        return $vendor_details;
    }

    public function change_admin_status(Request $request,$admin_id,$current_status) {
        $admin_details = AdminModel::query();
        $vendor_details = VendorModel::query();


        $new_status=$current_status=='1'?0:1;


        $admin_details = $admin_details->where('id', $admin_id)->update(['status' =>$new_status]);
        $admin_update=AdminModel::query()->where('id', $admin_id)->first()->toArray();
        $vendor_details=$vendor_details->where('id', $admin_update['vendor_id'])->update(['status' =>$new_status]);

        $vendor_update=VendorModel::query()->where('id', $admin_update['vendor_id'])->first()->toArray();
        $updated_admin_status=$admin_update['status'];
        $updated_vendor_status=$admin_update['status'];
        if($updated_admin_status==$updated_vendor_status){
            // if both updates matches,any of updated_admin_status and updated_vendor_status
            // can be used to send update to frontend
        return ['updated_status'=>$updated_admin_status];


        }


    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
