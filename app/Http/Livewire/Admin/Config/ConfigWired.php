<?php

namespace App\Http\Livewire\Admin\Config;

use App\Models\Admin as AdminModel;
use App\Models\Config as ConfigModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
// shop_logo
class ConfigWired extends Component
{
    public $image;
    public $config_img_path='config';
    protected $rules = ['image' => 'image'];
    public $message = [
        'image.image' => 'This field only takes image inputs',
    ];

    protected $config_val_obj = [
        'shop_name' => 'required',
        'shop_number' => 'required',
        'shop_address' => 'required',
        'shop_location' => 'required',
        'shop_email' => 'required',
        'shop_tin_number' => 'required',
    ];
    // public $email_rules= Rule::unique('admins', 'email');
    // public $val_admin_obj = [
    //     'name' => 'required|regex:/^[\pL\s\-]+$/u',
    //     'email' =>Rule::unique('admins', 'email'),
    //     // ->ignore($this->user)
    //     'password' => 'required|confirmed|min:6',
    //     'mobile' => 'required',

    // ];
     #
    public $inputs = [];
    public $inputs_2 = [];

    use WithFileUploads;
    public function removeImg()
    {

        $this->image = '';
        $this->dispatchBrowserEvent('clear-fieild');
    }
    public function store_pic($media_file, $shop_name)
    {
        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'shop_logo' . "_" . $shop_name . "_." . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->config_img_path . '\\';

            $img = Image::make($media_file);
            $img->save($uploaded_img_path . $new_file_name);
            // $img->fit(73, 73)->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }
    public function submitConfig()
    {
        if ($this->image) {
            $this->validate($this->rules, $this->message);

        }
        $config_data = Validator::make($this->inputs, $this->config_val_obj)->validate();
        // dd($config_data);

        $admin_data = Validator::make($this->inputs_2,
         ['name' => 'required|regex:/^[\pL\s\-]+$/u',
        'email' =>'required|'.Rule::unique('admins', 'email'),
        // ->ignore($this->user)
        'password' => 'required|confirmed|min:10|alpha_num|max:30',
        'mobile' => 'required',])
        ->validate();
        $passRaw=$admin_data['password'];
        $admin_data['password'] = Hash::make($admin_data['password']);

        $admin_data['type'] = 'superadmin';
        $admin_data['photo'] = '';
        $admin_data['status'] = 1;
        if ($this->image) {
            $config_data['shop_logo'] = $this->store_pic($this->image, $config_data['shop_name']);
        } else {
            $config_data['shop_logo'] = '';
        }

        $newAdmin = AdminModel::create($admin_data);
        $newConfig = ConfigModel::create($config_data);
        // Auth::login($newAdmin);
        $this->dispatchBrowserEvent('success-dashboard-redirect',['success_msg'=>'You are done setting up!Good Luck!']);

        if (Auth::guard('admin')->attempt(['email' => $admin_data['email'], 'password' =>  $passRaw, 'status' => 1])) {
            return redirect('/admin/dashboard');
        } else {
            return back()->with('error_msg', "LOGIN FAILED!");
        }




    }
    public function render()
    {
        return view('livewire.admin.config.config-wired');
    }
}
