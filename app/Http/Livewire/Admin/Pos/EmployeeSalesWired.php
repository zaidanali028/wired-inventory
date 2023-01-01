<?php

namespace App\Http\Livewire\Admin\Pos;

use Livewire\Component;
use App\Models\Orders as OrdersModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin as AdminModel;

class EmployeeSalesWired extends Component
{
    use WithPagination;
    protected $orders;
    public $admin_details;

    public $query_today=false;
    protected $paginationTheme = 'bootstrap';

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
        $query =OrdersModel::query()->groupBy('issued_by');

        // Order by creation date, eager load related data, and paginate the results
        return $query->orderBy('created_at', 'desc')
            ->paginate(100);

    }

    public function orders_today()
    {
        $this->query_today=true;
        $admin = Auth::guard('admin')->user();

        // Build the base query depending on whether the user is a superadmin
        $query = OrdersModel::query()->groupBy('issued_by') ;

        // Fetch today's date in the correct format
        $today = date('d/m/Y');
        // Query today's orders, load relationships, and paginate
        $this->orders = $query->where('order_date', $today)
            ->latest()
            ->with(['get_customer'])
            ->paginate(100);


    }



    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $today = date('d/m/Y');




        $sales_today= OrdersModel::query()->where('order_date', $today)->sum('total');
        $sales_overall=OrdersModel::query()->sum('total');


        return view('livewire.admin.pos.employee-sales-wired',[
            'orders' => $this->orders,
            'sales_today'=>$this->number_to_kmb($sales_today),
            'sales_overall'=>$this->number_to_kmb($sales_overall)

        ]);
    }

    function number_to_kmb($number)
    {
        $number = intVal($number);
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . "B";
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . "M";
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . "K";
        } else {
            return $number;
        }
    }
}
