<?php

namespace App\Http\Livewire\Admin\Pos;

use App\Models\Admin as AdminModel;
use App\Models\Orders as OrdersModel;
use App\Models\Config as ConfigModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersWired extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $orderRecord_ = [];
    public $orderRecord_id;
    public $product_img_path = 'product_imgs';
    public $date_today;
    public $current_page;

    public $admin_details;
    protected $orders;
    public function mount()
    {
        $this->orders = $this->default_order_query();
        // when  mounting,this query will be the query for orders by default
        // this happens once

    }

    public function get_orders($startMonth, $endMonth)
    {
        $start_date = Carbon::now()->startOfYear()->month(intVal($startMonth))->toDateTimeString();
        // $end_date = Carbon::now()->startOfYear()->month(intVal($endMonth))->toDateTimeString();
        $end_date = Carbon::now()->endOfYear()->month(intVal($endMonth))->toDateTimeString();
        // dd( $start_date, $end_date);
        $this->orders = OrdersModel::whereBetween(
            'created_at', [$start_date, $end_date]
        )->latest()->with(['get_customer'])->paginate(15);
        // dd( $this->orders);
    }
    public function orders_today()
    {
        $this->orders = OrdersModel::where(['order_date' => date('d/m/Y')])->latest()->with(['get_customer'])->paginate(15);

    }
    public function show_view_order($orderRecord_id)
    {

        $this->orderRecord_id = $orderRecord_id;
        $this->orderRecord_ = OrdersModel::with(['get_customer', 'get_order_detail'])->where(['id' => $this->orderRecord_id])->first()->toArray();
        $this->orderRecord_['company_details']=ConfigModel::first()->toArray();
        // dd($this->orderRecord_['company_details']['shop_name']);

        $this->dispatchBrowserEvent('show-view-order-modal');


    }

    public function print_order($order_id)
    {
        $this->orderRecord_id = $order_id;
        $this->orderRecord_ = OrdersModel::with(['get_customer', 'get_order_detail'])->where(['id' => $this->orderRecord_id])->first()->toArray();
        $this->orderRecord_['company_details']=ConfigModel::first()->toArray();
        dd($this->orderRecord_);

    }
    public function default_order_query()
    {
        return OrdersModel::orderBy('created_at', 'desc')->with(['get_customer'])->paginate(15);
    }
    public function render()
    {
        $order = '';
        if (!empty($this->orders)) {
            // when rendering(which happens each time a
            // call is made th the backend,
            // 1. I check to see if there is an already exsisting
            // query stored in $this-> orders
            // and if there is,I will store that same order

            $orders = $this->orders;
        } else {
            // else if there isnt I will do the default order query
            $orders = $this->default_order_query();

        }
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // dd($this->orders);

        $this->current_page = Session::get('page');

        return view('livewire.admin.pos.orders-wired', [
            'orders' => $orders,
            'date_today' => $this->date_today,

        ]);
    }
}