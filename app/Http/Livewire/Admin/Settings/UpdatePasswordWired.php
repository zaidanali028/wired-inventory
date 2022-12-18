<?php

namespace App\Http\Livewire\Admin\Settings;




use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePasswordWired extends Component
{
    // new admin pass[30303030]

    public $admin_details;
    public $inputs=[];
    public $user_pwd_validation_obj = [
        'current_password' => 'required',
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|min:8',
    ];

    public function update_password()
    {
//    dd(ucwords('hello world'));
        $validated_data = Validator::make($this->inputs, $this->user_pwd_validation_obj)->validate();
        if (Hash::check($this->inputs['current_password'], Auth::guard('admin')->user()->password)) {
            if ($this->inputs['confirm_password'] == $this->inputs['new_password']) {
                AdminModel::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($this->inputs['new_password'])]);
                // return back()->with('success_msg', "You Succeeded Updating Your Password!");
                // $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'Password Successfully changed']);
                $this->dispatchBrowserEvent('success-dashboard-redirect',['success_msg'=>ucwords("You have succeeded in updating your yuta-pass!")]);

            } else {
                // return back()->with('error_msg', "New Password Doesn't Match Confirm Password!");
                $this->dispatchBrowserEvent('show-error-toast', ["error_msg" => "New Password Doesn't Match Confirm Password!"]);

            }
        } else {
            return back()->with('error_msg', "Current Password Is Wrong!");
        }

    }

    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.settings.update-password-wired');
    }
}
