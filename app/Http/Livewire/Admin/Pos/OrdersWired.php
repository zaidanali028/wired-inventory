<?php

namespace App\Http\Livewire\Admin\Pos;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin as AdminModel;
use App\Models\Orders as OrdersModel;


use Livewire\Component;

class OrdersWired extends Component
{
    public $orderRecord_=[];
    public $orderRecord_id;
    public $product_img_path='product_imgs';

    public $admin_details;
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
        $orders = OrdersModel::with(['get_customer'])->latest()->paginate(15);
        // dd($this->orders);



        return view('livewire.admin.pos.orders-wired',[
            'orders'=>$orders
        ]);
    }
}
