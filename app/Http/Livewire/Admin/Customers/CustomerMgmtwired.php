<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Admin as AdminModel;
use App\Models\Customers as CustomerModel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

use Livewire\WithFileUploads;
use Livewire\WithPagination;


class CustomerMgmtwired extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $customers_by_type;
    public $customer_details;
    public $addNewcustomer = false;
    public  $date_today;
    public  $current_page;

    public $customer_id;
    public $photo;
    public $btn_text;
    public $inputs = [];
    public $del_customer_id;
    public $val_customer_obj = [
        'name' => 'required|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email',


        'phone' => 'required',
        'address' => 'required',

    ]; #
    protected $rules = ['photo' => 'image'];
    public $message = [
        'photo.image' => 'This field only takes image inputs',
    ];
    public $customer_img_path = 'customer_imgs';
protected $listeners=[
'confirm_cust_del'=>'confirm_cust_del'
];


    use WithFileUploads;
    use WithPagination;

    public function removeImg()
    {
        $this->photo = '';
        $this->dispatchBrowserEvent('clear-fieild');

    }

    public function newcustomer()
    {
        $this->addNewcustomer = true;
        $this->inputs = [];
        $this->btn_text = $this->addNewcustomer == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-customer-modal');
        // triggering the show-add-customer-modal to show  modal

    }




    public function store_pic($media_file, $customer_name)
    {
        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'customer_pic' . "_" . $customer_name . "_." . $file_ext;
            $uploaded_img_path = public_path() . '\\storage\\' . $this->customer_img_path . '\\';

            $img = Image::make($media_file);
            $img->fit(300, 300)->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }
    public function confirm_cust_del()
    {
        $employee_to_delete = CustomerModel::findOrFail($this->del_customer_id);
        $employee_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'customer Deleted SuccessFully!']);

    }
    public function submitaddNewcustomer()
    {
        // dd($this->inputs['type']);

        // image validation
            if($this->photo){
        $this->validate($this->rules, $this->message);

            }
        // data validation
        $validated_data = Validator::make($this->inputs, $this->val_customer_obj)->validate();
        $record_count = CustomerModel::where(['email' => $this->inputs['email']])->count();
        if ($record_count >= 1) {
            $this->dispatchBrowserEvent('emp_rec_err', ['msg' => 'Record Already Exsists!']);

        } else {
            $customer = new CustomerModel;
            $customer->name = $validated_data['name'];
            $customer->phone = $validated_data['phone'];
            $customer->email = $validated_data['email'];
            $customer->address = $validated_data['address'];

            if ($this->photo) {
                $customer->photo = $this->store_pic($this->photo, $customer->name);
            }

            $this->photo = '';

            $customer->save();
    $this->dispatchBrowserEvent('hide-add-customer-modal');
    $this->dispatchBrowserEvent('show-success-toast', ['success_msg'=> 'New Customer With The Name ' . $customer->name . ' Added SuccessFully']);


        }

    }
    public function editcustomer($customer_id)
    {
        $this->customer_id = $customer_id;

        $this->addNewcustomer = false;
        $this->btn_text = $this->addNewcustomer == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-customer-modal');
        // triggering the show-add-customer-modal to show  modal

        // $this->customer_details = CustomerModel::where('id', $customer_id)->first()->toArray();
        $this->inputs = CustomerModel::where('id', $customer_id)->first()->toArray();

    }

    public function updatecustomer()
    {
        $ad = CustomerModel::where('id', $this->customer_id)->first()->toArray();
        // if(!empty($ad))
        if (!empty($ad['photo']) && empty($this->photo)) {
            $this->rules['photo'] = '';

        } else {
            $this->rules['photo'] = 'image';

        }

        // datavalidation

        $validated_data = Validator::make($this->inputs, $this->val_customer_obj)->validate();
        // browser dispath here!.........

        // imagevalidation

        if ($this->photo) {
            // new photo uploaded

            $this->validate($this->rules, $this->message);

            if (!empty($this->inputs['photo'])) {
                // there is also previous photo
                Storage::disk('public')->delete($this->customer_img_path . '/' . $this->inputs['photo']);

            }

            $validated_data['photo'] = $this->store_pic($this->photo, $this->inputs['photo']);

        }

        CustomerModel::where('id', $this->customer_id)->update($validated_data);
        $this->photo = '';
        $this->dispatchBrowserEvent('hide-add-customer-modal', ['success_msg' => 'Successfully Updated customer Data ']);

    }

    public function deletecustomerConfirm($del_customer_id)
    {
        $this->del_customer_id = $del_customer_id;
        // dd( $this->del_customer_id );
        $this->dispatchBrowserEvent('show_cust_del_confirm');

    }

    public function confirmcustomerDelete()
    {
        $customer_to_delete = CustomerModel::findOrFail($this->del_customer_id);
        $customer_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'Customer Deleted SuccessFully!']);

    }

    public function customerStatChanger($customer_id, $customer_status)
    {
        $new_stat = $customer_status == 0 ? 1 : 0;

        CustomerModel::where('id', $customer_id)->update(['status' => $new_stat]);
        // $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'customer Status Updated Successfully!']);
        $this->dispatchBrowserEvent('success-dashboard', ['success_msg' => ucwords("You have succeeded in updating customer's status!")]);
        return redirect()->back();

    }
    public function yo()
    {
        dd('yo');
    }

    public function render()
    {



        // $customers_by_type=CustomerModel::latest()->paginate(15)->toArray();
        $customers = CustomerModel::latest()->paginate(15);

       $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

       return view('livewire.admin.customers.customer-mgmtwired',['admin_details'=> $admin_details,'customers'=>$customers]);



    }
}
