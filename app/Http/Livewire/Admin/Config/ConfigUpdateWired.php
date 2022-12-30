<?php

namespace App\Http\Livewire\Admin\Config;
use App\Models\Admin as AdminModel;
use App\Models\Config as ConfigModel;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ConfigUpdateWired extends Component
{
    use WithFileUploads;
    public $config_img_path='config';


    public $admin_details;
    public $image;
    protected $config_val_obj = [
        'shop_name' => 'required',
        'shop_number' => 'required',
        'shop_address' => 'required',
        'shop_location' => 'required',
        'shop_email' => 'required',
        'shop_tin_number' => 'required',
    ];
    protected $rules = ['image' => 'image'];
    public $message = [
        'image.image' => 'This field only takes image inputs',
    ];
    public $inputs=[];
    public $shop_img_path='config';


    public function store_pic($media_file, $shop_name)
    {
        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'shop_logo' . "_" . $shop_name . "_." . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->config_img_path . '\\';

            $img = Image::make($media_file);
            // $img->fit(73, 73)->save($uploaded_img_path . $new_file_name);
            $img->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }

    public function updateConfig(){


    // data(text) validation
    $validated_data = Validator::make($this->inputs, $this->config_val_obj)->validate();
 // media validation
 if(empty($this->image)){
    $this->rules['image'] = '';


}else{
// user has passed a file
$this->rules['image'] = 'image';


    $this->validate($this->rules, $this->message);
    // validate user file and ensure its an image file

    if (!empty($this->inputs['shop_logo'])) {
        // there is also previous image
        Storage::disk('public')->delete($this->config_img_path.'/' .$this->inputs['shop_logo']);
    }


    $validated_data['shop_logo'] = $this->store_pic($this->image, $validated_data['shop_name']);

}

    ConfigModel::where(['id'=>$this->inputs['id']])->update($validated_data);
    $this->dispatchBrowserEvent('success-dashboard-redirect', ["success_msg" => 'Your Shop Has Been Officially Updated!']);
    $this->removeImg();
    $this->inputs=[];





    }

    public function removeImg()
    {

        $this->image = '';
        $this->dispatchBrowserEvent('clear-fieild');
    }

    public function render()
    {
        $this->inputs=ConfigModel::all()->first()->toArray();

        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.config.config-update-wired');
    }
}
