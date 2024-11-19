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
use NumberFormatter;
class PosManagementWired extends Component
{
    protected $listeners = ['ready_for_print'];
    public $orderRecord_ = [];

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
    public $cartItems = [];

    public $products;
    public $order_validation_object = [
        // 'customer_id' => 'required',
        'payBy' => 'required',
        'pay' => 'required|numeric',

    ];

    function numberToWords($num)
    {
        // Check if the input is numeric
        if (!is_numeric($num)) {
            throw new \InvalidArgumentException("Input must be a numeric value.");
        }

        // Handle negative numbers
        if ($num < 0) {
            return "Negative " . $this->numberToWords(abs($num));
        }

        // Split into integer and decimal parts
        $integerPart = (int) $num;
        $decimalPart = round(($num - $integerPart) * 100); // Convert decimals to whole numbers (e.g., 0.80 -> 80)

        // Format the integer part
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $integerWords = ucfirst($formatter->format($integerPart));

        // Format the decimal part if any
        if ($decimalPart > 0) {
            $decimalWords = ucfirst($formatter->format($decimalPart));
            return " {$integerWords} Ghana Cedis  and {$decimalWords} Pesewas";
        }

        return $integerWords;
    }

    function formatNumber($num)
    {
        try {
            // Format number with commas
            $formattedNumber = number_format($num, 2);
            // Convert number to words
            $numberInWords = $this->numberToWords($num);

            return "GH₵ $formattedNumber - $numberInWords";
        } catch (\InvalidArgumentException $e) {
            return "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            return "An unexpected error occurred: " . $e->getMessage();
        }
    }

    // this attribut will aid in keeping track of the current tab
    //  ,is home by default
    public $current_tab = 'home';

    public $search = '';



    public function mount()
    {

        // as soon as view is mounted, set discount to 0
        $this->inputs['discount'] = 0;
        // $this->cartItems[153]=0;
        $this->cartItems = PosModel::pluck('product_quantity', 'product_id')->toArray();
        // dd( $this->cartItems );
    }

    public function getCategoryProducts($cat_id)
    {
        $this->current_tab = 'category';
        $this->current_category_id = $cat_id;
        $this->category_items = ProductsModel::where(['category_id' => $this->current_category_id])->latest()->get()->toArray();
        // dd($this->category_items);

    }
    public function ready_for_print()
    {
        $this->show_view_order($this->orderRecord_id);

    }
    public function show_view_order($orderRecord_id)
    {

        $this->orderRecord_id = $orderRecord_id;
        $this->orderRecord_ = OrdersModel::with(['get_customer', 'get_order_detail'])->where(['id' => $this->orderRecord_id])->first()->toArray();
        $this->orderRecord_['company_details'] = ConfigModel::first()->toArray();
        // dd($this->orderRecord_['company_details']['shop_name']);

        $this->dispatchBrowserEvent('show-view-order-modal');


    }

    public function add_to_cart($id)
    {
        // Check if the quantity exists in the cartItems array
        $new_qty = isset($this->cartItems[$id]) ? $this->cartItems[$id] : 1;

        // Check product availability in catalog
        // Get the product from the ProductsModel
        $product = ProductsModel::where('id', $id)->first();
        if ($product->product_quantity < $new_qty) {
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => "This product is left with just ($product->product_quantity) pcs",
            ]);
            return;
        }
        // Typecast the value to an integer
        $new_qty = (int) $new_qty;
        // Ensure the new quantity is valid
        if (!is_int($new_qty) || $new_qty < 1) {
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => 'Please provide a [POSITIVE] numeric value!',
            ]);
            // return;
            $this->cartItems[$id] = 1;
            $new_qty = $this->cartItems[$id];

        }

        // Check product availability in ProductsModel
        $product = ProductsModel::where('id', $id)->first();
        if (!$product || $product->product_quantity <= 0) {
            $this->clicked_product_id = '';
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => 'This operation is not possible!',
            ]);
            return;
        }

        // Check if the product already exists in PosModel
        $exist_product = PosModel::where('product_id', $id)->first();

        if ($exist_product) {
            // Update the existing product's quantity and subtotal
            $exist_product->update([
                'product_quantity' => $new_qty,
                'sub_total' => $exist_product->product_price * $new_qty,
            ]);
        } else {

            // Add the new product to PosModel
            PosModel::create([
                'product_id' => $id,
                'product_name' => $product->product_name,
                'product_quantity' => 1,
                'product_price' => $product->selling_price,
                'sub_total' => $product->selling_price,
            ]);
        }

        // Refresh the cart items to reflect the latest quantities
        $pos_product = PosModel::where('product_id', $id)->first();
        $this->cartItems[$id] = $pos_product->product_quantity;

        // Provide user feedback
        $this->clicked_product_id = $id;
        $this->dispatchBrowserEvent('show-success-toast', [
            'success_msg' => 'Successfully updated cart!',
        ]);
    }

    public function decrease_from_cart($id)
    {
        // Check if the quantity exists in the cartItems array
        $new_qty = isset($this->cartItems[$id]) ? $this->cartItems[$id] : 1;
        // Get the product from the ProductsModel
        $product = ProductsModel::where('id', $id)->first();
        if ($product->product_quantity < $new_qty) {
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => "This product is left with just ($product->product_quantity) pcs",
            ]);
            return;
        }

        // Typecast the value to an integer
        $new_qty = (int) $new_qty;
        // Ensure the new quantity is valid and not less than 1
        if (!is_int($new_qty) || $new_qty < 1) {
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => 'Invalid quantity!',
            ]);
            return;
        }

        // Get the product from the ProductsModel
        $product = ProductsModel::where('id', $id)->first();
        if (!$product || $product->product_quantity <= 0) {
            $this->clicked_product_id = '';
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => 'This operation is not possible!',
            ]);
            return;
        }

        // Check if the product exists in the PosModel
        $exist_product = PosModel::where('product_id', $id)->first();

        if ($exist_product) {
            // Decrease quantity in cart if it's greater than 1
            if ($exist_product->product_quantity > 1) {
                $exist_product->update([
                    'product_quantity' => $exist_product->product_quantity - 1,
                    'sub_total' => $exist_product->product_price * ($exist_product->product_quantity - 1),
                ]);
            } else {
                // If quantity is 1, you might want to delete it
                $exist_product->delete();
            }
        } else {
            // If the product is not in the cart, you can't decrease it
            $this->dispatchBrowserEvent('show-error-toast', [
                'error_msg' => 'This product is not in the cart.',
            ]);
            return;
        }

        // Update the cartItems array with the new quantity
        $pos_product = PosModel::where('product_id', $id)->first();
        if ($pos_product) {
            $this->cartItems[$id] = $pos_product->product_quantity;
        }

        // Provide feedback to the user
        $this->clicked_product_id = $id;
        $this->dispatchBrowserEvent('show-success-toast', [
            'success_msg' => 'Successfully updated cart!',
        ]);
    }

    public function cart_item_delete($product_id)
    {
        PosModel::where('product_id', $product_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast', ['success_msg' => 'Successfully Removed Item From Cart!']);

    }
    public function generate_anonymous_cust()
    {
        $microtime = microtime(true);

        // Generate a random number with 7 digits using mt_rand()
        $randomNumber = mt_rand(1000000, 9999999);

        // Concatenate the current time and the random number to create a unique number
        return $uniqueCustomer = 'anonymous_customer_' . (string) $microtime . (string) $randomNumber;
    }


    public function process_order()
    {
        if (!Auth::guard('admin')->user()) {
            $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'Please [SIGN IN!] to submit order!!']);
            return;


        }
        // dd(empty($this->inputs['customer_id']));

        $validated_data = Validator::make($this->inputs, $this->order_validation_object)->validate();
        if (!empty($this->inputs['customer_id'])) {
            $validated_data['customer_id'] = $this->inputs['customer_id'];
            // dd( $validated_data['customer_id']);
        } elseif (empty($this->inputs['cutomer_id'])) {
            // if when processing the order,
            // no customer was chosen,an anonymous
            // customer is created
            $data = [];
            $data['name'] = $this->generate_anonymous_cust();
            $data['email'] = $data['name'] . '@anonymous-mail.com';
            $data['phone'] = 'anonymous';
            $data['address'] = 'anonymous';
            $data["created_at"] = date('Y-m-d H:i:s');
            $data["updated_at"] = date('Y-m-d H:i:s');

            $customer_id = CustomersModel::insertGetId($data);
            $validated_data['customer_id'] = $customer_id;


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
        $data["issued_by"] = Auth::guard('admin')->user()->id;


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
                $this->orderRecord_id = $order_id;

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
        $this->admin_details = Auth::guard('admin')->user() ? AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray() : [];
        $this->customers = CustomersModel::orderBy('name')->where('address', '!=', 'anonymous')->latest()->get();

        if ($this->pos_item_count > 0) {

            if (isset($this->inputs['pay']) && $this->inputs['pay'] != '' && is_numeric($this->inputs['pay'])) {
                $amount_paid = $this->inputs['pay'];

                if ($this->inputs['pay'] >= $this->sub_total) {
                    $this->inputs['due'] = $amount_paid - $this->sub_total;
                    $this->inputs['due'] = $this->inputs['due'] < 1000000000000 ? $this->formatNumber($this->inputs['due']) : "Number Too Large!";



                } else {
                    $this->inputs['pay'] = '';
                    $this->inputs['due'] = '';
                    $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'Invalid [PAY] amountT!']);

                }

            } else {
                $this->inputs['pay'] = '';
                $this->inputs['due'] = '';

                // $this->dispatchBrowserEvent('show-error-toast', ['error_msg' => 'Invalid [PAY] amount!']);

            }
            if (isset($this->inputs['discount'])) {
                $discount_given = $this->inputs['discount'];
                if ($discount_given < $this->sub_total) {
                    $this->total = $this->sub_total - floatval($discount_given);
                } else {
                    $this->inputs['discount'] = '';
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

        } elseif ($this->current_tab == 'home') {
            $this->products = ProductsModel::latest()->get()->toArray();

        }


        return view('livewire.admin.pos.pos-management-wired');
    }
}
