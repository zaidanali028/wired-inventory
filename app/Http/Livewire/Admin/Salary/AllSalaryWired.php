<?php

namespace App\Http\Livewire\Admin\Salary;

use App\Models\Admin as AdminModel;
use App\Models\Salary as SalaryModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use App\Models\EmployeeModel as EmployeeModel;
use Illuminate\Support\Facades\Validator;

class AllSalaryWired extends Component
{
    use WithPagination;
    // protected $paginationTheme = 'bootstrap';
    public $salary_id='';
    public $employee=[];
    public $employee_id='';
    public $inputs=[];
    public $salary_month_validation=[
        'salary_month'=>'required'
    ];
    public $months=[
        "January","February","March","April","May","June"
        ,"July","August","September","October","November","December"
            ];

    // nav-item(wire:ignore)
    // tab-pane(wire:ignore.self)



    public function editSalary($salary_id){
        $this->salary_id=$salary_id;
        $salary_month=SalaryModel::where(['id'=>$this->salary_id])->get()->first();
        $this->employee_id=$salary_month['employee_id'];



        $this->employee=EmployeeModel::where(['id'=>$this->employee_id])->get()->first()->toArray();


        $this->inputs['employee_name']= $this->employee['name'];
        $this->inputs['employee_email']= $this->employee['email'];
        $this->inputs['employee_salary']= $this->employee['salary'];
        $this->inputs['salary_month']= $salary_month['salary_month'];
        $this->dispatchBrowserEvent('show-add-salary-modal');


    }
    public function update_salary(){

        // dd($this->salary_id);

    $validated_data = Validator::make($this->inputs, $this->salary_month_validation)->validate();
    $month=$validated_data['salary_month'];


    $data = [];

    $data['employee_id'] = $this->employee_id;
    $data['amount'] = $this->employee['salary'];
    	$data['salary_date'] = date('d/m/Y');
    	$data['salary_month'] = $month;
    	$data['salary_year'] = date('Y');
        $employee_salary=SalaryModel::where([
        'id'=>$this->salary_id,
        'employee_id'=> $this->employee_id,])
        ->update($data);


        $this->dispatchBrowserEvent('hide-add-salary-modal');
        $this->dispatchBrowserEvent('success-dashboard',['success_msg'=>'*REFRESH TO SEE UPDATE!'.$month.'\'s debt for '.$this->employee['name'].' Has Been Updated Successfully!']);


    }

    public function render()
    {
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $salary_by_mnths = SalaryModel::with(['get_emp'])->latest()->get()->groupBy('salary_month');




        return view('livewire.admin.salary.all-salary-wired')->with(compact('admin_details', 'salary_by_mnths'));
    }
}
