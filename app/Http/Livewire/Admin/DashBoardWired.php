<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin as AdminModel;
use App\Models\Customers as CustomersModel;
use App\Models\Orders as OrdersModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashBoardWired extends Component
{
    protected $admin_details;
    protected $today_sell;
    protected $sell_pct_change;
    protected $income_pct_change;
    protected $due_pct_change;
    protected $today_income;
    protected $today_due;
    protected $total_customers;
    protected $customer_pct_change;

    public function get_monthly_rate_diff($column_name)
    {
        // this function aids in getting percentage difference between
        // this month and last month
        $startOfLastMonth = Carbon::now()->subMonths(1)->startOfMonth()->toDateTimeString();
        $endOfLastMonth = Carbon::now()->subMonths(1)->endOfMonth()->toDateTimeString();

        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $lastMonthRecord = OrdersModel::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum($column_name);
        $thisMonthRecord = OrdersModel::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->sum($column_name);

        $rate_pct = $lastMonthRecord != 0 ? ($thisMonthRecord / $lastMonthRecord) * 100 : 0;
        return $rate_pct = number_format($rate_pct, 2);

    }
    public function get_monthly_customer_RateDiff(){
        $CurrentCustomerCount = CustomersModel::whereMonth('created_at', '=', now()->month)->count();
        $LastCustomerCount = CustomersModel::whereMonth('created_at', '=', now()->subMonth()->month)->count();
        $rate_pct=$LastCustomerCount!=0?$CurrentCustomerCount/$LastCustomerCount*100:0;
        return $rate_pct = number_format($rate_pct, 2);

    }
   
    public function mount()
    {

        $this->today_sell = OrdersModel::where('order_date', date('d/m/Y'))->sum('total');
        $this->sell_pct_change = $this->get_monthly_rate_diff('total');

        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        $this->today_due = OrdersModel::where('order_date', date('d/m/Y'))->sum('due');
        $this->due_pct_change = $this->get_monthly_rate_diff('due');

        $this->today_income = OrdersModel::where('order_date', date('d/m/Y'))->sum('pay');
        $this->income_pct_change = $this->get_monthly_rate_diff('pay');

        $this->total_customers = CustomersModel::count();
        $this->customer_pct_change =$this->get_monthly_customer_RateDiff();
       

    }

    public function render()
    {
        return view('livewire.admin.dash-board-wired', [
            'admin_details' => $this->admin_details,
            'today_sell' => $this->today_sell,
            'today_income' => $this->today_income,
            'today_due' => $this->today_due,
            'sell_pct_change' => $this->sell_pct_change,
            'income_pct_change' => $this->income_pct_change,
            'due_pct_change' => $this->due_pct_change,
            'customer_pct_change'=>$this->customer_pct_change,
            'total_customers' => $this->total_customers,
            
        ]);
    }
}
