<?php

namespace App\Http\Livewire\Admin\Config;

use App\Models\Admin as AdminModel;
use App\Models\Config as ConfigModel;
use App\Models\Logo as LogoModel;
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
      protected $rules = [
        'image.*' => 'image',
        'image'=>'array|size:2'
];
protected $messages = [
        'image.*.image' => 'This field only takes image inputs',
        'image.image'=>'The system requires (2) images,1 for mini logo(40 x 34) and the other for medium logo(138/34)'

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
    public function store_pic($media_files, $shop_name,$config_id){
        $final_images=[];
      //   [0]=>40/34
      //   [1]=>138/34
          if (!empty($media_files)) {
              foreach ($media_files as $index=>$media_file) {
                  $file_ext = $media_file->getClientOriginalExtension();
                  $new_file_name = 'shop_logo_'.$index . "_" . $shop_name . "_." . $file_ext;
                  $uploaded_img_path = public_path() . '\\storage\\' . $this->config_img_path . '\\';

                  $img = Image::make($media_file);
                  // $img->fit(73, 73)->save($uploaded_img_path . $new_file_name);
                  $img->save($uploaded_img_path . $new_file_name);

                  $final_images[$index]=$new_file_name;

                  $logo=new LogoModel;
                  $logo->media_name=$new_file_name;
                  $logo->config_id=$config_id;
                  $logo->media_index=$index;
                  $logo->save();



              }




          }
          return $final_images;

      }
    public function submitConfig()
    {
        if ($this->image) {
            $this->validate($this->rules, $this->messages);

        }

        $config_data = Validator::make($this->inputs, $this->config_val_obj)->validate();
        // dd($config_data);

        $admin_data = Validator::make($this->inputs_2,
         [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
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

        $newAdmin = AdminModel::create($admin_data);
        $newConfigId = ConfigModel::insertGetId($config_data);

        if ($this->image) {

             $this->store_pic($this->image, $config_data['shop_name'],$newConfigId);
        }
        $config_data['shop_logo'] ='';

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