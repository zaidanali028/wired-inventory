<?php

namespace App\Http\Livewire\Admin\Pos;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin as AdminModel;
use App\Models\Orders as OrdersModel;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


use Livewire\Component;

class OrdersWired extends Component
{
    public $orderRecord_=[];
    public $orderRecord_id;
    public $product_img_path='product_imgs';
    public  $date_today;
    public  $current_page;

    public $admin_details;
    protected  $orders;
    public function mount()
    {
        $this->orders = OrdersModel::orderBy('created_at', 'desc')->with(['get_customer'])->paginate(15);

    }

    public function get_orders($startMonth,$endMonth){
        $start_date = Carbon::now()->startOfYear()->month(intVal($startMonth))->toDateTimeString();
        // $end_date = Carbon::now()->startOfYear()->month(intVal($endMonth))->toDateTimeString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->month(intVal($endMonth))->toDateTimeString();
        // dd( $start_date, $endOfThisMonth);
        $this->orders = OrdersModel::whereBetween(
            'created_at', [$start_date,$endOfThisMonth]
            )->latest()->with(['get_customer'])->paginate(15);

    }
    public function orders_today(){
        $this->orders=OrdersModel::where(['order_date'=>date('d/m/Y')])->latest()->with(['get_customer'])->paginate(15);

    }
    public function show_view_order($orderRecord_id){

        $this->orderRecord_id=$orderRecord_id;
        $this->orderRecord_ = OrdersModel::with(['get_customer','get_order_detail'])->where(['id'=>$this->orderRecord_id])->first()->toArray();
        // $this->orderRecord_=$this->orderRecord_->toArray();
        // dd($this->orderRecord_);

        $this->dispatchBrowserEvent('show-view-order-modal');
        // $this->orderRecord_ =[];


    }
    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // dd($this->orders);


        $this->date_today = date("F j, Y", strtotime(strtr(Session::get('date'), '/', '-')));
        $this->current_page=Session::get('page');





        return view('livewire.admin.pos.orders-wired',[
            'orders'=>$this->orders,
            'date_today'=>$this->date_today

        ]);
    }
}
