<?php

namespace App\Http\Livewire\Admin\Pos;

use App\Models\Admin as AdminModel;
use App\Models\Orders as OrdersModel;
use App\Models\Config as ConfigModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


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
        $admin = Auth::guard('admin')->user();

        // Build the base query depending on whether the user is a superadmin
        $query = $admin->type == 'superadmin' ? OrdersModel::with('get_issued_admin')->query() : OrdersModel::with('get_issued_admin')->where('issued_by', $admin->id);

        // Apply the date filter, relationships, and pagination
        $this->orders = $query->whereBetween('created_at', [$start_date, $end_date])
            ->latest()
            ->with(['get_customer'])
            ->paginate(100);


    }
    public function orders_today()
    {
        // dd();
        $admin = Auth::guard('admin')->user();

        // Build the base query depending on whether the user is a superadmin
        $query = $admin->type == 'superadmin' ? OrdersModel::query()->with('get_issued_admin'): OrdersModel::with('get_issued_admin')->where('issued_by', $admin->id);

        // Fetch today's date in the correct format
        $today = date('d/m/Y');
        // Query today's orders, load relationships, and paginate
        $this->orders = $query->where('order_date', $today)
            ->latest()
            ->with(['get_customer'])
            ->paginate(100);


    }
    public function show_view_order($orderRecord_id)
    {

        $this->orderRecord_id = $orderRecord_id;
        $admin = Auth::guard('admin')->user();

// Build the base query depending on whether the user is a superadmin
$query = $admin->type == 'superadmin' ? OrdersModel::query() : OrdersModel::where('issued_by', $admin->id);

// Query the order record by ID and load related data
$this->orderRecord_ = $query->with(['get_customer', 'get_order_detail'])
    ->where('id', $this->orderRecord_id)
    ->first()
    ->toArray();

        $this->orderRecord_['company_details'] = ConfigModel::first()->toArray();
        // dd($this->orderRecord_['company_details']['shop_name']);

        $this->dispatchBrowserEvent('show-view-order-modal');


    }

    public function print_order($order_id)
    {
        $this->orderRecord_id = $order_id;
        $admin = Auth::guard('admin')->user();

        // Build the base query depending on whether the user is a superadmin
        $query = $admin->type == 'superadmin' ? OrdersModel::query() : OrdersModel::where('issued_by', $admin->id);

        // Query the order record by ID and load related data
        $this->orderRecord_ = $query->with(['get_customer', 'get_order_detail'])
            ->where('id', $this->orderRecord_id)
            ->first()
            ->toArray();

        $this->orderRecord_['company_details'] = ConfigModel::first()->toArray();
        dd($this->orderRecord_);

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
        $query = $admin->type == 'superadmin' ? OrdersModel::query()->with('get_issued_admin') : OrdersModel::with('get_issued_admin')->where('issued_by', $admin->id);


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
        $today = date('d/m/Y');

        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $sales_today=$query->where('order_date', $today)->sum('total');


        $this->current_page = Session::get('page');

        return view('livewire.admin.pos.orders-wired', [
            'orders' => $orders,
            'date_today' => $this->date_today,
            'sales_today'=>$this->number_to_kmb($sales_today)

        ]);
    }
}
