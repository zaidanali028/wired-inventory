<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\Admin as AdminModel;
use App\Models\EmployeeModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EmployeeManagemenWired extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $employee_details;
    public $addNewEmployee = false;
    public $admin_img_path = 'admin_imgs';

    // public $employee_id;
    public $btn_text;
    public $delete_sec_id;
    public $photo;
    public $employee_type = 'employee';
    public $inputs;
    public $employee_id;

    public $val_emp_obj = ['name' => 'required|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email',
        'mobile' => 'required',
        'address' => 'required',
        'salary' => 'required|numeric',
        'national_id' => 'required',
        'joining_date' => 'required',
    ];
    protected $rules = ['photo' => 'required'];
    public $message = [
        'photo.image' => 'This field only takes image inputs',
    ];

    protected $listeners = [
        'getEmp' => 'getEmp',
        'confirm_emp_del' => 'confirm_emp_del',
    ];

    protected $paginationTheme = 'bootstrap';

    public function newEmployee()
    {
        $this->addNewEmployee = true;
        $this->inputs = [];
        $this->btn_text = $this->addNewEmployee == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-employee-modal');

    }

    public function getEmp($emp_id)
    {
        $emp_record = AdminModel::where(['id' => $emp_id, 'type' => $this->employee_type,])->first()->toArray();
        $this->inputs['name'] = $emp_record['name'];
        $this->inputs['email'] = $emp_record['email'];
        $this->inputs['mobile'] = $emp_record['mobile'];
        $this->inputs['photo'] = $emp_record['photo'];

    }

    public function submitaddNewEmployee()
    { // datavalidation
        // dd($this->inputs);
        $validated_data = Validator::make($this->inputs, $this->val_emp_obj)->validate();

        // imagevalidation

        //employee_record_validation
        $record_count = EmployeeModel::where(['emplyee_id' => $this->inputs['id']])->count();
        if ($record_count >= 1) {
            $this->dispatchBrowserEvent('emp_rec_err', ['msg' => 'record Already Exsists!']);

        } else {
            $employee = new EmployeeModel;

            $employee->name = $validated_data['name'];
            $employee->emplyee_id = $this->inputs['id'];
            $employee->email = $validated_data['email'];
            $employee->mobile = $validated_data['mobile'];
            $employee->address = $validated_data['address'];
            $employee->salary = $validated_data['salary'];
            $employee->national_id = $validated_data['national_id'];
            $employee->joining_date = $validated_data['joining_date'];
            $format_date = date("d-m-Y", strtotime($employee->joining_date));
            $employee->joining_date = date("j F Y", strtotime($format_date));
            $employee->save();
            $this->dispatchBrowserEvent('hide-add-employee-modal',);
            $this->dispatchBrowserEvent('show-success-toast', ['success_msg'=> 'New Employee With The Name ' . $employee->name . ' Added SuccessFully']);

        }

    }

    public function editEmployee($emp_id)
    {
        $this->employee_id = $emp_id;
        $emp_record = EmployeeModel::where(['id' => $emp_id])->first()->toArray();

        $this->inputs = $emp_record;

        $this->inputs['id'] = $emp_record['emplyee_id'];
        $this->addNewEmployee = false;
        $this->btn_text = $this->addNewEmployee == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-employee-modal');

    }

    public function updateEmployee()
    {
        // datavalidation

        $validated_data = Validator::make($this->inputs, $this->val_emp_obj)->validate();
        EmployeeModel::where('id', $this->employee_id)->update($validated_data);
        $this->dispatchBrowserEvent('hide-add-employee-modal-', ['success_msg' => 'Successfully Added  A New Employee ']);

    }



    public function deleteEmployeeConfirm($delete_sec_id)
    {
        $this->employee_id = $delete_sec_id;
        $this->dispatchBrowserEvent('show_emp_del_confirm');

    }

    public function confirm_emp_del()
    {
        $employee_to_delete = EmployeeModel::findOrFail($this->employee_id);
        $employee_to_delete->delete();


        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'employee Deleted SuccessFully!']);
        redirect()->back();

    }

    public function render()
    {
        $employees_data = AdminModel::where(['type'=>$this->employee_type,'status'=>1])->get()->toArray();
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $employees = EmployeeModel::latest()->paginate(15);
        return view('livewire.admin.employees.employee-managemen-wired', [
            'employees' => $employees,
            'employees_data' => $employees_data,
        ]);
    }
}
