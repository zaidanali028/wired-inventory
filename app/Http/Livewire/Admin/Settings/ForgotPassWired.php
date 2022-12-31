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
        $message='Hello there,kindly use '.$msg.' as your new shop passwordFor security reasons,change it as soon as you rollback onto your admin portal for your safety sytemsByZaid';
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

        dd( $res);

    }

    public function submitForgotPass()
    {
        Validator::make($this->inputs, [
            'email' => 'required|email',
        ])->validate();

        if (AdminModel::where(['email' => $this->inputs['email']])->count() >= 1) {
            $admin = AdminModel::where(['email' => $this->inputs['email']]);
            $new_pass = Str::random(15);
            $admin->update([
                'password' => Hash::make($new_pass),
            ]);
            $receiver=$admin->first()->toArray()['mobile'];
            $this->send_sms($new_pass,$receiver);

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
