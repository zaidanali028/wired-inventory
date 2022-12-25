<?php

namespace App\Http\Livewire\Admin\Salary;
use Livewire\WithPagination;
use App\Models\Admin as AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeModel as EmployeeModel;
use App\Models\Salary as SalaryModel;



use Livewire\Component;



class SalaryManagementWired extends Component
{

    use WithPagination;
    public $addNewSalary = false;
    public $btn_text;
    public $admin_img_path='admin_imgs';
    public $inputs=[];
    public $employee;
    protected $Salary_data=[];
    protected $Employees_data=[];
    public $employee_id;
    public $months=[
"January","February","March","April","May","June"
,"July","August","September","October","November","December"
    ];
    public $salary_month_validation=[
        'salary_month'=>'required'
    ];





public function process_salary(){
    $validated_data = Validator::make($this->inputs, $this->salary_month_validation)->validate();
    $month=$validated_data['salary_month'];
    $check = SalaryModel::where([
        'employee_id'=> $this->employee_id,
        'salary_month'=> $month
        ])->first();
    	if ($check) {
            $employee=$this->employee->name;
            $this->dispatchBrowserEvent('show-error-toast',['error_msg'=>$month.'\'s debt for '.$employee.'Has Been Settled Already!']);
    	}else{
    $data = [];
    $data['employee_id'] = $this->employee_id;
    $data['amount'] = $this->employee->salary;
    	$data['salary_date'] = date('d/m/Y');
    	$data['salary_month'] = $month;
    	$data['salary_year'] = date('Y');
        $data["created_at"] = date('Y-m-d H:i:s');
        $data["updated_at"] = date('Y-m-d H:i:s');
        SalaryModel::insert($data);

        // $this->dispatchBrowserEvent('show-success-toast',['success_msg'=>$month.'\'s debt for'.$this->employee.'Has Been Settled Successfully!']);
        $this->dispatchBrowserEvent('hide-add-salary-modal');
        $this->dispatchBrowserEvent('success-dashboard',['success_msg'=>$month.'\'s debt for '.$this->employee->name.' Has Been Settled Successfully!']);


        }




}
    public function newSalary($emp_id)
    {
        $this->addNewSalary = true;
        $this->employee_id=$emp_id;
        $this->employee=EmployeeModel::where(['id'=>$emp_id])->get()->first();
        $this->inputs = [];
        $this->inputs['employee_name']= $this->employee->name;
        $this->inputs['employee_email']= $this->employee->email;
        $this->inputs['employee_salary']= $this->employee->salary;
        // $this->inputs['salary_month'];

        $this->btn_text = $this->addNewSalary == true ? 'Save' : 'Save Changes';

        $this->dispatchBrowserEvent('show-add-salary-modal');

    }
    public function render()
    {
        $admin_details=  AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();;
        $Employees_data= EmployeeModel::orderBy('created_at', 'desc')->with(['get_employee_admin_data'])->paginate(15);
        // dd($Employees_data);
        return view('livewire.admin.salary.salary-management-wired')->with(compact('admin_details','Employees_data'));
    }
}
