<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminsWired extends Component
{
    // public $admins_by_type;
    public $admin_details;
    public $addNewadmin = false;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'confirm_admin_del' => 'confirmadminDelete',
    ];

    public $current_page;

    public $admin_id;
    public $photo;
    public $btn_text;
    public $inputs = [];
    public $del_admin_id;
    // public $val_admin_obj = [
    //     'name' => 'required|regex:/^[\pL\s\-]+$/u',
    //     'email' => 'required|email',
    //     'password' => 'required',
    //     'status' => 'required',
    //     'type' => 'required',
    //     'mobile' => 'required',

    // ]; #
    protected $rules = ['photo' => 'required|image'];
    public $message = [
        'photo.image' => 'This field only takes photo inputs',
    ];
    public $admin_img_path = 'admin_imgs';

// protected $rules = ['photo' => 'required|photo'];

    use WithFileUploads;
    use WithPagination;

    public function removeImg()
    {
        $this->photo = '';
        $this->dispatchBrowserEvent('clear-fieild');

    }

    public function newadmin()
    {
        $this->addNewadmin = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show-add-admin-modal');
        // triggering the show-add-admin-modal to show  modal
        $this->btn_text = $this->addNewadmin == true ? 'Save' : 'Save Changes';

    }

    public function deleteAlladmins()
    {
        $this->dispatchBrowserEvent('show_admin_del_confirm');
        // invoking this to show confirm with js in customjs

    }

    public function confirmadminDelAll()
    {
        // deleting all sub categories
        AdminModel::query()->delete();
        redirect()->back();
        $this->dispatchBrowserEvent('delete_comfirmation', ["success_msg" => 'Cleared All admins Successfully']);

    }
    public function store_pic($media_file, $admin_name)
    {
        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'admin_pic' . "_" . $admin_name . "_." . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->admin_img_path . '\\';
            // $uploaded_img_path = public_path() . '\\storage\\' . $this->admin_img_path . '\\';

            $img = Image::make($media_file);
            $img->fit(300, 300)->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }
    public function submitaddNewadmin()
    {
        // dd($this->inputs['type']);

        // photo validation
        $this->validate($this->rules, $this->message);

        // data validation
        $validated_data = Validator::make($this->inputs,
            ['name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|'
                 . Rule::unique('admins', 'email'),
                'type' => 'required',
                'status' => 'required',
                'password' => 'required|min:10|alpha_num|max:30',
                'mobile' => 'required'])->validate();

        $record_count = AdminModel::where(['email' => $this->inputs['email']])->count();
        if ($record_count >= 1) {
            $this->dispatchBrowserEvent('emp_rec_err', ['msg' => 'record Already Exsists!']);

        } else {
            $admin = new AdminModel;
            // dd($validated_data);
            $admin->name = $validated_data['name'];
            $admin->type = $validated_data['type'];
            $admin->mobile = $validated_data['mobile'];
            $admin->email = $validated_data['email'];
            $admin->status = $validated_data['status'];
            $admin->password = Hash::make($validated_data['password']);

            if ($this->photo) {
                $admin->photo = $this->store_pic($this->photo, $admin->name);
            }
            $admin->save();
            $this->photo = '';
            $this->dispatchBrowserEvent('hide-add-admin-modal', ['success_msg' => 'New Admin With The Name ' . $admin->name . ' Added SuccessFully']);

        }

    }
    public function editadmin($admin_id)
    {
        $this->admin_id = $admin_id;

        $this->addNewadmin = false;
        $this->btn_text = $this->addNewadmin == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-admin-modal');
        // triggering the show-add-admin-modal to show  modal

        // $this->admin_details = AdminModel::where('id', $admin_id)->first()->toArray();
        $this->inputs = AdminModel::where('id', $admin_id)->first()->toArray();
        $this->inputs['password'] = '';

    }

    public function updateadmin()
    {
        $ad = AdminModel::where('id', $this->admin_id)->first()->toArray();
        // if(!empty($ad))
        if (!empty($ad['photo']) && empty($this->photo)) {
            $this->rules['photo'] = '';

        } else {
            $this->rules['photo'] = 'image';

        }

        // datavalidation

        $validated_data = Validator::make($this->inputs, ['name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required| unique:admins,email,' . $this->admin_id,
            // $this->admin_id aids validator to remove current user's
            // email from unique email validation
            'type' => 'required',
            'status' => 'required',


            'password' => 'required|min:10|alpha_num|max:30',
            'mobile' => 'required',
        ])->validate();

        // dd($this->inputs['password']);
        $validated_data['password'] = Hash::make($validated_data['password']);

        // imagevalidation

        if ($this->photo) {
            // new photo uploaded

            $this->validate($this->rules, $this->message);

            if (!empty($this->inputs['photo'])) {
                // there is also previous photo
                Storage::disk('public')->delete($this->admin_img_path . '/' . $this->inputs['photo']);

            }

            $validated_data['photo'] = $this->store_pic($this->photo, $this->inputs['photo']);

        }

        AdminModel::where('id', $this->admin_id)->update($validated_data);
        $this->photo = '';
        $this->dispatchBrowserEvent('hide-add-admin-modal', ['success_msg' => 'Successfully Updated Admin Data ']);

    }

    public function deleteadminConfirm($del_admin_id)
    {
        $this->del_admin_id = $del_admin_id;
        $this->dispatchBrowserEvent('show_admin_del_confirm');

    }

    public function confirmadminDelete()
    {
        $admin_to_delete = AdminModel::findOrFail($this->del_admin_id);
        $admin_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'admin Deleted SuccessFully!']);

    }

    public function adminStatChanger($admin_id, $admin_status)
    {
        $new_stat = $admin_status == 0 ? 1 : 0;

        AdminModel::where('id', $admin_id)->update(['status' => $new_stat]);
        // $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'Admin Status Updated Successfully!']);
        $this->dispatchBrowserEvent('success-dashboard', ['success_msg' => ucwords("You have succeeded in updating admin's status!")]);
        return redirect()->back();

    }

    public function render()
    {

        $admins_by_type = AdminModel::latest()->paginate(15);
        // $this->inputs = AdminModel::where('id', $admin_id)->first()->toArray();

        // $admins = AdminModel::latest()->paginate(15);

        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
// dd($this->admin_details,  $this->admins_by_type);
        return view('livewire.admin.admins.admins-wired', [
            'admins_by_type' => $admins_by_type,
        ]);
    }
}
