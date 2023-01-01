<?php

namespace App\Http\Livewire\Admin\Pos;

use Livewire\Component;
use App\Models\Orders as OrdersModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EmployeeSalesWired extends Component
{
    use WithPagination;
    protected $orders;


    public function mount()
    {
        $this->orders = $this->default_order_query();
        // when  mounting,this query will be the query for orders by default
        // this happens once

    }
    public function default_order_query()
    {
        $admin = Auth::guard('admin')->user();

        // Build the base query depending on whether the user is a superadmin
        $query = $admin->type == 'superadmin' ? OrdersModel::query()->with('get_issued_admin') : OrdersModel::with('get_issued_admin')->where('issued_by', $admin->id);

        // Order by creation date, eager load related data, and paginate the results
        return $query->orderBy('created_at', 'desc')
            ->with(['get_customer'])
            ->paginate(100);

    }
    public function render()
    {
        $admin=Auth::guard('admin')->user();
        $query =OrdersModel::query()->with('get_issued_admin') ;
        // dd($query);

        return view('livewire.admin.pos.employee-sales-wired',[
            'orders' => $this->orders,

        ]);
    }
}
