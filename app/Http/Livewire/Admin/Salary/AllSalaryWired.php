<?php

namespace App\Http\Livewire\Admin\Salary;

use App\Models\Admin as AdminModel;
use App\Models\Salary as SalaryModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class AllSalaryWired extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // nav-item(wire:ignore)
    // tab-pane(wire:ignore.self)

    public function makeSearchwORK(){
        
    }
    public function render()
    {
        $admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $salary_by_mnths = SalaryModel::with(['get_emp'])->latest()->get()->groupBy('salary_month');
// dd( $salary_by_mnths);

        // dd($salary_by_mnths);



        return view('livewire.admin.salary.all-salary-wired')->with(compact('admin_details', 'salary_by_mnths'));
    }
}
