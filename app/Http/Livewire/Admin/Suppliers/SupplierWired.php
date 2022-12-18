<?php

namespace App\Http\Livewire\Admin\Suppliers;
use App\Models\Admin as AdminModel;
use App\Models\Supplier as SupplierModel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SupplierWired extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $suppliers_by_type;
    public $supplier_details;
    public $addNewsupplier = false;

    public $supplier_id;
    public $photo;
    public $btn_text;
    public $inputs = [];
    public $del_supplier_id;
    public $val_supplier_obj = [
        'name' => 'required|regex:/^[\pL\s\-]+$/u',
        'shopName' => 'regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email',


        'phone' => 'required',
        'address' => 'required',

    ]; #
    protected $rules = ['photo' => 'image'];
    public $message = [
        'photo.image' => 'This field only takes image inputs',
    ];
    public $supplier_img_path = 'supplier_imgs';
protected $listeners=[
'confirm_sup_del'=>'confirm_sup_del'
];


    use WithFileUploads;
    use WithPagination;

    public function removeImg()
    {
        $this->photo = '';
        $this->dispatchBrowserEvent('clear-fieild');

    }

    public function newsupplier()
    {
        $this->addNewsupplier = true;
        $this->inputs = [];
        $this->btn_text = $this->addNewsupplier == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-supplier-modal');
        // triggering the show-add-supplier-modal to show  modal

    }

    public function deleteAllsuppliers()
    {
        $this->dispatchBrowserEvent('show_supplier_del_confirm');
        // invoking this to show confirm with js in customjs

    }


    public function store_pic($media_file, $supplier_name)
    {
        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'supplier_pic' . "_" . $supplier_name . "_." . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->supplier_img_path . '\\';

            $img = Image::make($media_file);
            $img->fit(300, 300)->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }
    public function confirm_sup_del()
    {
        $employee_to_delete = SupplierModel::findOrFail($this->del_supplier_id);
        $employee_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'Supplier Deleted SuccessFully!']);

    }
    public function submitaddNewSupplier()
    {
        // dd($this->inputs['type']);

        // image validation
            if($this->photo){
        $this->validate($this->rules, $this->message);

            }
        // data validation
        $validated_data = Validator::make($this->inputs, $this->val_supplier_obj)->validate();
        $record_count = SupplierModel::where(['email' => $this->inputs['email']])->count();
        if ($record_count >= 1) {
            $this->dispatchBrowserEvent('emp_rec_err', ['msg' => 'Record Already Exsists!']);

        } else {
            $supplier = new SupplierModel;
            $supplier->name = $validated_data['name'];
            $supplier->phone = $validated_data['phone'];
            $supplier->email = $validated_data['email'];
            $supplier->address = $validated_data['address'];

            if ($this->photo) {
                $supplier->photo = $this->store_pic($this->photo, $supplier->name);
            }
            if ($this->inputs['shopName']) {
                $supplier->shopName = $validated_data['shopName'];
            }
            $this->photo = '';

            $supplier->save();
    $this->dispatchBrowserEvent('hide-add-supplier-modal');
    $this->dispatchBrowserEvent('show-success-toast', ['success_msg'=> 'New Employee With The Name ' . $supplier->name . ' Added SuccessFully']);


        }

    }
    public function editsupplier($supplier_id)
    {
        $this->supplier_id = $supplier_id;

        $this->addNewsupplier = false;
        $this->btn_text = $this->addNewsupplier == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-supplier-modal');
        // triggering the show-add-supplier-modal to show  modal

        // $this->supplier_details = SupplierModel::where('id', $supplier_id)->first()->toArray();
        $this->inputs = SupplierModel::where('id', $supplier_id)->first()->toArray();

    }

    public function updatesupplier()
    {
        $ad = SupplierModel::where('id', $this->supplier_id)->first()->toArray();
        // if(!empty($ad))
        if (!empty($ad['photo']) && empty($this->photo)) {
            $this->rules['photo'] = '';

        } else {
            $this->rules['photo'] = 'image';

        }

        // datavalidation

        $validated_data = Validator::make($this->inputs, $this->val_supplier_obj)->validate();
        // browser dispath here!.........

        // imagevalidation

        if ($this->photo) {
            // new photo uploaded

            $this->validate($this->rules, $this->message);

            if (!empty($this->inputs['photo'])) {
                // there is also previous photo
                Storage::disk('public')->delete($this->supplier_img_path . '/' . $this->inputs['photo']);

            }

            $validated_data['photo'] = $this->store_pic($this->photo, $this->inputs['photo']);

        }

        SupplierModel::where('id', $this->supplier_id)->update($validated_data);
        $this->photo = '';
        $this->dispatchBrowserEvent('hide-add-supplier-modal', ['success_msg' => 'Successfully Updated Supplier Data ']);

    }
    // public function submitAddNewsupplier(){
    //     // dd($this->inputs);
    //     $validated_data=Validator::make($this->inputs,[
    //         'name'=>'required',
    //         'status'=>'required'

    //     ])->validate();

    //     SupplierModel::create($validated_data);
    //     redirect()->back();
    //     $this->dispatchBrowserEvent('hide-add-supplier-modal',["success_msg"=>'New supplier Added Successfully']);

    // }

    public function deletesupplierConfirm($del_supplier_id)
    {
        $this->del_supplier_id = $del_supplier_id;
        $this->dispatchBrowserEvent('show_sup_del_confirm');

    }

    public function confirmsupplierDelete()
    {
        $supplier_to_delete = SupplierModel::findOrFail($this->del_supplier_id);
        $supplier_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'Supplier Deleted SuccessFully!']);

    }

    public function supplierStatChanger($supplier_id, $supplier_status)
    {
        $new_stat = $supplier_status == 0 ? 1 : 0;

        SupplierModel::where('id', $supplier_id)->update(['status' => $new_stat]);
        // $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'supplier Status Updated Successfully!']);
        $this->dispatchBrowserEvent('success-dashboard', ['success_msg' => ucwords("You have succeeded in updating supplier's status!")]);
        return redirect()->back();

    }
    public function yo()
    {
        dd('yo');
    }

    public function render()
    {

        // $suppliers_by_type=SupplierModel::latest()->paginate(15)->toArray();
        $suppliers = SupplierModel::latest()->paginate(15);

       $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.suppliers.supplier-wired',['admin_details'=> $admin_details,'suppliers'=>$suppliers]);


    }
}
