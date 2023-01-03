<?php

namespace App\Http\Livewire\Admin\Pos;

use App\Models\Admin as AdminModel;
use App\Models\Categories as CategoriesModel;
use App\Models\Customers as CustomersModel;
use App\Models\OrderDetails as OrderDetailsModel;
use App\Models\Config as ConfigModel;
use App\Models\Orders as OrdersModel;
use App\Models\Pos as PosModel;
use App\Models\Products as ProductsModel;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class PosManagementWired extends Component
{
protected $listeners=['ready_for_print'];
public $orderRecord_=[];

    public $admin_details;
    public $pos_products;
    public $pos_item_count;
    public $customers;
    public $total;
    public $sub_total;
    public $total_qty;
    public $date_today;
    public $current_page;
    public $orderRecord_id;

    public $categories;
    public $product_img_path = 'product_imgs';
    public $category_items;
    public $current_category_id;
    public $clicked_product_id;

    public $inputs = [];
    public $products;
    public $order_validation_object = [
        // 'customer_id' => 'required',
        'payBy' => 'required',
        'pay' => 'required|numeric',

    ];

    // this attribut will aid in keeping track of the current tab
    //  ,is home by default
    public $current_tab = 'home';

    public $search='';



    public function getCategoryProducts($cat_id)
    {
        $this->current_tab = 'category';
        $this->current_category_id = $cat_id;
        $this->category_items = ProductsModel::where(['category_id' => $this->current_category_id])->latest()->get()->toArray();
        // dd($this->category_items);

    }
    public function ready_for_print(){
        $this->show_view_order($this->orderRecord_id);

    }
    public function show_view_order($orderRecord_id)
    {

        $this->orderRecord_id = $orderRecord_id;
        $this->orderRecord_ = OrdersModel::with(['get_customer', 'get_order_detail'])->where(['id' => $this->orderRecord_id])->first()->toArray();
        $this->orderRecord_['company_details']=ConfigModel::first()->toArray();
        // dd($this->orderRecord_['company_details']['shop_name']);

        $this->dispatchBrowserEvent('show-view-order-modal');


    }

    public function add_to_cart($id)
    {
        if (ProductsModel::where('id', $id)->first()->product_quantity <= 0) {
            $this->clicked_product_id = '';

            $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'This Operation Aint Possible!']);

        } else {
            $exist_product = PosModel::where('product_id', $id)->first();

            if ($exist_product) {
                // if product already exsists in cart,

                PosModel::where('product_id', $id)->increment('product_quantity');

                $product = PosModel::where('product_id', $id)->first();
                $sub_total = $product->product_price * $product->product_quantity;
                PosModel::where('product_id', $id)->update(['sub_total' => $sub_total]);

            } else {
                // else add one product to cart
                $product = ProductsModel::where('id', $id)->first();

                $data = [];
                $data['product_id'] = $id;
                $data['product_name'] = $product->product_name;
                $data['product_quantity'] = 1;
                $data['product_price'] = $product->selling_price;
                $data['sub_total'] = $product->selling_price;

                PosModel::insert($data);
            }

            $this->clicked_product_id = $id;
            $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'Successfully Updated Cart!']);

        }
    }
    public function decrease_from_cart($id)
    {
        if (PosModel::where('product_id', $id)->first()->product_quantity <= 1) {
            $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'This Operation Aint Possible!']);

        } else {
            $quantity = PosModel::where('product_id', $id)->decrement('product_quantity');

            $product = PosModel::where('product_id', $id)->first();
            $sub_total = $product->product_price * $product->product_quantity;
            PosModel::where('product_id', $id)->update(['sub_total' => $sub_total]);

            $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'Item Removed From Cart!']);

        }

    }
    public function cart_item_delete($product_id)
    {
        PosModel::where('product_id', $product_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'Successfully Removed Item From Cart!']);

    }
    public function generate_anonymous_cust(){
        $microtime = microtime(true);

// Generate a random number with 7 digits using mt_rand()
$randomNumber = mt_rand(1000000, 9999999);

// Concatenate the current time and the random number to create a unique number
return $uniqueCustomer ='anonymous_customer_'. (string)$microtime . (string)$randomNumber;
    }


    public function process_order()
    {
        // dd(empty($this->inputs['customer_id']));

        $validated_data = Validator::make($this->inputs, $this->order_validation_object)->validate();
        if(!empty($this->inputs['customer_id'])){
            $validated_data['customer_id']=$this->inputs['customer_id'];
            // dd( $validated_data['customer_id']);
        }

        elseif(empty($this->inputs['cutomer_id'])){
            // if when processing the order,
            // no customer was chosen,an anonymous
            // customer is created
            $data=[];
            $data['name'] =$this->generate_anonymous_cust();
            $data['email']=  $data['name'] .'@anonymous-mail.com';
            $data['phone'] ='anonymous';
            $data['address'] ='anonymous';
            $data["created_at"] = date('Y-m-d H:i:s');
        $data["updated_at"] = date('Y-m-d H:i:s');

        $customer_id = CustomersModel::insertGetId($data);
        $validated_data['customer_id']=$customer_id;


        }
        $data = [];
        $data['customer_id'] = $validated_data['customer_id'];
        $data['qty'] = $this->total_qty;
        $data['sub_total'] = $this->sub_total;
        $data['total'] = $this->total;
        $data['due'] = isset($this->inputs['due']) ? $this->inputs['due'] : '0';
        $data['discount'] = isset($this->inputs['discount']) ? $this->inputs['discount'] : '0';
        $data['vat'] = 0;

        $data['pay'] = $validated_data['pay'];

        $data['payBy'] = $validated_data['payBy'];

        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
        $data['day'] = date('j');
        $data["created_at"] = date('Y-m-d H:i:s');
        $data["updated_at"] = date('Y-m-d H:i:s');

        $order_id = OrdersModel::insertGetId($data);

        $cartContents = PosModel::get();
        $this->total = '';
        $this->sub_total = '';

        $cartData = [];
        foreach ($cartContents as $content) {
            $cartData['order_id'] = $order_id;
            $cartData['product_id'] = $content->product_id;
            $cartData['product_quantity'] = $content->product_quantity;
            $cartData['product_price'] = $content->product_price;
            $cartData['sub_total'] = $content->sub_total;
            $product = ProductsModel::where('id', $content->product_id)->first()->toArray();
            $product_qty = intVal($product['product_quantity']);

            if ($product_qty < $content->product_quantity) {
                // product in db is less than requested product
                OrdersModel::findOrFail($order_id)->delete();
                $product_name = $product['product_name'];
                $err_msg = 'This Operation Aint Possible, [' . ucfirst($product_name) . '] Must Be Either Removed Or Deleted From Cart.The Amount Requested Aint Available!';
                $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => $err_msg]);

            } else {
                // dd($cartData);
                OrderDetailsModel::insert($cartData);


                ProductsModel::where('id', $content->product_id)->update(['product_quantity' => $product_qty - $content->product_quantity]);

                PosModel::query()->delete();
                $this->orderRecord_id= $order_id ;

                $this->dispatchBrowserEvent('success-orders-redirect', ['success_msg' => 'Order Placed Successfully,Will You Like To Preview Orders?']);
            }
        }

    }



    public function home_tab_clicked()
    {
        $this->current_tab = 'home';




    }

    public function render()
    {


        $this->categories = CategoriesModel::where(['status' => 1])->latest()->get()->toArray();
        $this->pos_products = PosModel::get();
        $this->pos_item_count = PosModel::get()->count();
        $this->sub_total = PosModel::sum('sub_total');
        $this->total = $this->sub_total;
        $this->total_qty = PosModel::sum('product_quantity');
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $this->customers = CustomersModel::orderBy('name')->where('address','!=','anonymous')->latest()->get();

        if ($this->pos_item_count > 0) {

            if (isset($this->inputs['pay'])) {
                $amount_paid = $this->inputs['pay'];
                if($this->inputs['pay']>=$this->sub_total){
                $this->inputs['due'] = floatval($amount_paid) - $this->sub_total;


                }else{
                    $this->inputs['pay']='';
            $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'Invalid [PAY] amount!']);

                }

            }
            if (isset($this->inputs['discount'])) {
                $discount_given = $this->inputs['discount'];
                if($discount_given <$this->sub_total){
                $this->total = $this->sub_total - floatval($discount_given);
             }else{
                $this->inputs['discount']='';
                $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'Invalid [DISCOUNT] amount!']);

                    }

            }
        } else {
            $this->inputs = [];
        }

        if (!empty($this->search)) {
            // dd($this->search,$this->current_tab);
            // client is searching.....
            $searchTerm = '%' . $this->search . '%';
            // searchTerm's '%' means anyting tha comes before and after what is being serched
            if ($this->current_tab == 'home') {
                // client is on the home tab and is searching something
                $this->products = ProductsModel::where([['product_name', 'like', $searchTerm]])->latest()->get()->toArray();
            } else if ($this->current_tab == 'category') {
                // client is on the category tab and is searching something
                $this->category_items = ProductsModel::where([['product_name', 'like', $searchTerm], ['category_id', $this->current_category_id]])->latest()->get()->toArray();

            }
        } elseif ($this->current_tab == 'category') {
            // we are on a specific category's page without searching anyting
            $this->category_items = ProductsModel::where(['category_id' => $this->current_category_id])->latest()->get()->toArray();

        }
        elseif ($this->current_tab == 'home') {
        $this->products = ProductsModel::latest()->get()->toArray();

        }


        return view('livewire.admin.pos.pos-management-wired');
    }
}
