<?php

namespace App\Http\Livewire\Admin\Expenses;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin as AdminModel;
use App\Models\Expense as ExpensesModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;


class ExpenseWired extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $Expenses ;
    public $addNewExpense = false;
    public $btn_text;
    public $inputs=[];
    public $expense_id;
    protected $listeners=[
        'confirm_expense_del'
    ];
    public $expense_val_obj = [
        'details' => 'required',
        'amount' => 'required',

    ];



    public function newExpense(){
        $this->inputs=[];
        $this->addNewExpense = true;
        $this->btn_text = $this->addNewExpense == true ? 'Save' : 'Save Changes';
        $this->dispatchBrowserEvent('show-add-Expense-modal');


    }
    public function confirm_expense_del(){
        ExpensesModel::findOrFail($this->expense_id)->delete();
       $this->dispatchBrowserEvent('hide-add-Expense-modal',['success_msg'=>'Expense Deleted Successfully!']);

    }
    public function deleteExpenseConfirm(){
        $this->dispatchBrowserEvent('show_expense_del_confirm');
    }
    public function updateExpense(){
        $validated_data = Validator::make($this->inputs, $this->expense_val_obj)->validate();
       if(!empty($this->inputs['expense_date'])){
        // $format_date = date("d-m-Y", strtotime($this->inputs['expense_date']));
        $validated_data['expense_date'] = $this->inputs['expense_date'];
            // dd( $validated_data['expense_date']);
       }
    //    dd($this->expense_id);
      $expense= ExpensesModel::where(['id'=>$this->expense_id])->first();
      $expense->update($validated_data);
    //   dd($expense->toArray());


    //   ->update($validated_data);
       $this->dispatchBrowserEvent('hide-add-Expense-modal',['success_msg'=>'Expense Updated Successfully!']);



    }
    public function submitaddNewExpense(){
        $validated_data = Validator::make($this->inputs, $this->expense_val_obj)->validate();
       if(!empty($this->inputs['expense_date'])){
        // $format_date = date("d-m-Y", strtotime($this->inputs['expense_date']));
        $validated_data['expense_date'] = $this->inputs['expense_date'];
            // dd( $validated_data['expense_date']);
       }
        ExpensesModel::create($validated_data);
        $this->dispatchBrowserEvent('hide-add-Expense-modal',['success_msg'=>'Expense Added Successfully!']);




    }
    public function editExpense($expense_id){
        $this->expense_id=$expense_id;
        $expense = ExpensesModel::where('id', $expense_id)->first()->toArray();

        $this->inputs= $expense;
        $this->btn_text = $this->addNewExpense == true ? 'Save' : 'Save Changes';

        $this->addNewExpense = false;
        $this->btn_text = $this->addNewExpense == true ? 'Save' : 'Save Changes';
        // dd($this->expense_id);
        $this->dispatchBrowserEvent('show-add-Expense-modal');


    }

    public function render()
    {
        $this->Expenses =ExpensesModel::orderBy('created_at', 'desc')->paginate(15);
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.expenses.expense-wired',[
            'Expenses'=>$this->Expenses
        ]);
    }
}
