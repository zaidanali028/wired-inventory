<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Admin as AdminModel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;

class ForgotPassWired extends Component
{

    public $inputs = [];

    public function send_sms($msg,$recepient)
    {
        $message="Hello there,kindly use ".$msg." as your new shop password.For security reasons,change it as soon as you rollback onto your admin portal for your shop's safety. #SytemsMadeByZaid";
        // $receipient mut be:
             //International format (233) excluding the (+)

        date_default_timezone_set('Africa/Accra');
		$sender = 'SUPA_IMS';
        $apiKey =env('TEXTCUS_API_KEY');

        $msg = urlencode($message);
        $sender = urlencode($sender);

         //11 Characters maximum

         $url = 'https://sms.textcus.com/api/send?apikey='.'yTO2MuW37OPmI0wXIttDypNlyKxqE2Pn'.'&destination='.$recepient.'&source='.$sender.'&dlr=0&type=0'.'&message='.$msg;

// dd($url);
         $res=file_get_contents($url);
         $res=json_decode($res);

        if($res->status=='0000'){
            return 1;

        }else{
            return 0;
        }

    }

    public function submitForgotPass()
    {
        Validator::make($this->inputs, [
            'email' => 'required|email',
        ])->validate();

        if (AdminModel::where(['email' => $this->inputs['email']])->count() >= 1) {
            $admin = AdminModel::where(['email' => $this->inputs['email']]);
            $new_pass = Str::random(10);
            $admin->update([
                'password' => Hash::make($new_pass),
            ]);

            $receiver=$admin->first()->toArray()['mobile'];
            if($this->send_sms($new_pass,$receiver)==1){
                // dd($new_pass);


                $this->dispatchBrowserEvent('success-dashboard', ['success_msg' => 'An SMS has been sent to your mobile number']);
                redirect('/admin/login');


            }

        } else {
            return back()->with('error_msg', "Invalid Email!");

        }

    }
    public function render()
    {
        // dd($this->email);
        return view('livewire.admin.settings.forgot-pass-wired');
    }
}
