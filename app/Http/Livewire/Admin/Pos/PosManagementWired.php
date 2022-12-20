<?php

namespace App\Http\Livewire\Admin\Pos;

use App\Models\Admin as AdminModel;
use App\Models\Categories as CategoriesModel;
use App\Models\Pos as PosModel;
use App\Models\Products as ProductsModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PosManagementWired extends Component
{
    public $admin_details;
    public $pos_products;
    public $pos_item_count;

    public $categories;
    public $product_img_path = 'product_imgs';
    public $category_items;
    public $current_category_id;
    public $clicked_product_id;
    public $sub_total_qty;
    public $total_qty;


    // this attribut will aid in keeping track of the current tab
    //  ,is home by default
    public $current_tab = 'home';

    public $search;

    public function getCategoryProducts($cat_id)
    {
        $this->current_tab = 'category';
        $this->current_category_id = $cat_id;
        // dd($current_category_id);
        $this->category_items = ProductsModel::where(['category_id' => $this->current_category_id])->latest()->get()->toArray();

    }

    public function add_to_cart($id)
	{
        if(ProductsModel::where('id', $id)->first()->product_quantity<=0){
        $this->clicked_product_id='';

            $this->dispatchBrowserEvent('show-error-toast',['error_msg'=>'This Operation Aint Possible!']);


        }else{
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
			$data['product_price'] = $product->selling_price;;
			$data['sub_total'] = $product->selling_price;

			PosModel::insert($data);
		}

        $this->clicked_product_id=$id;
        $this->dispatchBrowserEvent('show-success-toast',['success_msg'=>'Successfully Updated Cart!']);

          }
	}
    public function decrease_from_cart($id){
        if(PosModel::where('product_id', $id)->first()->product_quantity<=1){
            $this->dispatchBrowserEvent('show-error-toast',['error_msg'=>'This Operation Aint Possible!']);


        }else{
            $quantity = PosModel::where('product_id', $id)->decrement('product_quantity');

            $product = PosModel::where('product_id', $id)->first();
            $sub_total = $product->product_price * $product->product_quantity;
            PosModel::where('product_id', $id)->update(['sub_total' => $sub_total]);


            $this->dispatchBrowserEvent('show-success-toast',['success_msg'=>'Item Removed From Cart!']);


        }


    }
    public function cart_item_delete($product_id)
	{
		PosModel::where('product_id', $product_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast',['success_msg'=>'Successfully Removed Item From Cart!']);


	}

    public function render()
    {
        $this->products = ProductsModel::latest()->get()->toArray();
        $this->categories = CategoriesModel::latest()->get()->toArray();
		$this->pos_products = PosModel::get();
		$this->pos_item_count = PosModel::get()->count();
        $this->sub_total_qty=PosModel::sum('sub_total');
        $this->total_qty=PosModel::sum('product_quantity');


        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        if (!empty($this->search)) {
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
        }

        return view('livewire.admin.pos.pos-management-wired');
    }
}
