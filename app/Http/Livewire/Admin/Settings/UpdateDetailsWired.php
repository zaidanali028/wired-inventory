<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Admin as AdminModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateDetailsWired extends Component
{
public $admin_img_path='admin_imgs';

    use WithFileUploads;
    public $admin_details;
    public $inputs = [];
    public $image;
    public $detail_rules = [
        'name' => 'required|regex:/^[\pL\s\-]+$/u',
        'mobile' => 'required',
        'email' => 'required|email',

    ];
    protected $rules = [
        'image.*' => 'image',

    ];
    public $messages = [
        'image.image' => 'This field only takes image inputs',
    ];

    public function removeImg()
    {
        $this->dispatchBrowserEvent('clear-fieild');
        $this->image = "";
    }

    public function update_details()
    {

        $file_ext = '';
        $new_file_name = '';
        if ($this->image) {
            $admin = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
            if ($admin['photo']) {
                Storage::disk('public')->delete('admin_imgs/' . $admin['photo']);

            }

            $this->validate($this->rules, $this->messages);
            $file_ext = $this->image[0]->getClientOriginalExtension();
            $new_file_name = 'admin_' . $this->inputs['name'] . '.' . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->admin_img_path.'\\' . '\\';
            Image::make($this->image[0])->save($uploaded_img_path . $new_file_name);

        }
        $validated_data = Validator::make($this->inputs, $this->detail_rules)->validate();

        $final_update_object = [
            'name' => $validated_data['name'],
            'mobile' => $validated_data['mobile'],
            'email' => $validated_data['email'],

        ];
        if (!empty($this->image[0])) {
            $final_update_object["photo"] = $new_file_name;

        }
        AdminModel::where('id', Auth::guard('admin')->user()->id)->update($final_update_object);
        // $site_name=Session::get('site_name');
        $this->dispatchBrowserEvent('success-dashboard-redirect', ['success_msg' => ucwords("You have succeeded in updating your details as an official admin!")]);

    }
    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $this->inputs = $this->admin_details;
        // dd(  $this->admin_details);

        return view('livewire.admin.settings.update-details-wired');

    }
}
