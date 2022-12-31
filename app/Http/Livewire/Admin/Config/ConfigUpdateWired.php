<?php

namespace App\Http\Livewire\Admin\Config;

use App\Models\Admin as AdminModel;
use App\Models\Config as ConfigModel;
use App\Models\Logo as LogoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigUpdateWired extends Component
{
    use WithFileUploads;
    public $config_img_path = 'config';

    public $admin_details;
    public $image;
    public $config_id;
    protected $config_val_obj = [
        'shop_name' => 'required',
        'shop_number' => 'required',
        'shop_address' => 'required',
        'shop_location' => 'required',
        'shop_email' => 'required',
        'shop_tin_number' => 'required',
    ];
    protected $rules = [
        'image.*' => 'image',
        'image' => 'array|size:2',
    ];
    public $configLogo=[];
    protected $messages = [
        'image.*.image' => 'This field only takes image inputs',
        'image.image' => 'The system requires (2) images,1 for mini logo(40 x 34) and the other for medium logo(138/34)',

    ];
    public $inputs = [];
    public $shop_img_path = 'config';

    public function store_pic($media_files, $shop_name, $config_id)
    {
        $final_images = [];
        //   [0]=>40/34
        //   [1]=>138/34
        //   [0]=>40/34
        //   [1]=>138/34
        if (!empty($media_files)) {
            foreach ($media_files as $index => $media_file) {
                $file_ext = $media_file->getClientOriginalExtension();
                $new_file_name = 'shop_logo_' . $index . "_" . $shop_name . "_." . $file_ext;
                $uploaded_img_path = public_path() . '\\storage\\' . $this->config_img_path . '\\';

                $img = Image::make($media_file);
                // $img->fit(73, 73)->save($uploaded_img_path . $new_file_name);
                $img->save($uploaded_img_path . $new_file_name);

                $final_images[$index] = $new_file_name;

                $logo = new LogoModel;
                $logo->media_name = $new_file_name;
                $logo->config_id = $config_id;
                $logo->media_index = $index;
                $logo->save();

            }

        }
        return $final_images;

    }

    public function updateConfig()
    {


        // dd($this->configLoogo);

        // data(text) validation
        $validated_data = Validator::make($this->inputs, $this->config_val_obj)->validate();
        // media validation
        if (empty($this->image)) {
            $this->rules = [];

        } else {
      // user has passed a file

            $this->validate($this->rules, $this->messages);
            // validate user file and ensure its an image file


            if (!empty($this->configLogo)) {
                // there is also previous image
                foreach($this->configLogo as $logo){
                Storage::disk('public')->delete($this->config_img_path . '/' . $logo['media_name']);
                LogoModel::findOrFail($logo['id'])->delete();

                }
            }

            $validated_data['shop_logo'] ='';
             $this->store_pic($this->image, $validated_data['shop_name'],$this->config_id);

        }

        ConfigModel::where(['id' => $this->inputs['id']])->update($validated_data);
        $this->dispatchBrowserEvent('success-dashboard-redirect', ["success_msg" => 'Your Shop Has Been Officially Updated!']);
        $this->removeImg();
        $this->inputs = [];

    }

    public function removeImg()
    {

        $this->image = [];
        $this->dispatchBrowserEvent('clear-fieild');
    }

    public function render()
    {
        $this->configLogo=LogoModel::all()->count()>=1?LogoModel::all()->toArray():[];
            // DD( $this->configLogo);

        $this->inputs = ConfigModel::all()->first()->toArray();
        $this->config_id = $this->inputs['id'];

        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.config.config-update-wired');
    }
}
