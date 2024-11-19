<?php

namespace App\Http\Livewire\Admin\Products;

// use Mtownsend\RemoveBg\RemoveBg;
// https://github.com/mtownsend5512/remove-bg
use App\Models\Admin as AdminModel;
use App\Models\Categories as CategoriesModel;
use App\Models\ProductAttributes as ProductAttributesModel;
use App\Models\Products as ProductsModel;
use App\Models\ProductsGallery as ProductsGalleryModel;
use App\Models\Supplier as SuppliersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;



/**
 *      NOTES:(features not done)
 * 1)resizing main image
 *
 *
 *
 * */
class ProductsWired extends Component
{
    use WithFileUploads;
    // C:\zidaan\SC\yuta-v2\vendor\livewire\livewire\src\TemporaryUploadedFile.php
    // the path above was modified by me to handle situations where a user uploads
    // something different from a picture
    use WithPagination;


    public $current_page;
    protected $paginationTheme = 'bootstrap';
    // allow livewire pagination
    public $admin_details;
    public $inputs = [];
    private $products;
    public $categories_from_section;
    public $product_img_path = 'product_imgs';

    public $product_details;
    public $addNewproduct = false;
    public $product_id;
    public $btn_text;
    public $image;
    public $delete_prd_id;
    public $current_product_id;
    public $current_supplier_id;
    public $current_category_id;
    // public $product_img_path='product_imgs';
    public $search = '';

    protected $rules = ['image' => 'image|mimes:jpeg,png'];
    public $message = [
        'image.image' => 'This field only takes image inputs',
    ];

    protected $listeners = ['confirm_product_delete' => 'confirmproductDelete', 'confirm_product_delete_all' => 'confirmproductDeleteAll', 'confirm_delete_only_vid' => 'confirmed_delete_only_vid'];
    // WORK ON DELETING MEDIA FILES(PICTURES AND VIDEOS WHEN DELETING PRODUCTS)
    public $product_validation_object = [
        'product_name' => 'required',
        'product_quantity' => 'required|numeric',
        'selling_price' => 'required|numeric',
        'category_id' => 'required',
        // product_code,,,uploaded_by

    ];

    protected $messages = [
        'product_attributes.*.size.required' => 'Please specify the size for this attribute',
        'product_attributes.*.price.required' => 'Please specify the price for this attribute',
        'product_attributes.*.stock.required' => 'Please specify the stock quantity for this attribute',

    ];



    public function DeleteVid()
    {
        $this->dispatchBrowserEvent('delete_only_vid');
    }
    public function confirmed_delete_only_vid()
    {
        // dd($this->product_id);
        $product = ProductsModel::where(['id' => $this->product_id])->first()->toArray();
        if (!empty($product['product_video'])) {
            Storage::disk('public')->delete('prdct_videos/' . $product['product_video']);
        }
        ProductsModel::where(['id' => $this->product_id])->update(['product_video' => '']);
        $this->inputs = ProductsModel::with(['product_imgs'])->where('id', $this->product_id)->first()->toArray();

        // $this->dispatchBrowserEvent('hide-add-product-modal', ["success_msg" => 'Video Successfully Removed']);

    }

    public function create_slug($product_name, $product_id)
    {
        //start product-slug cration
        //    creating a slug with a record's product;s name
        $create_slug = Str::slug($product_name, '-');
        // checking if this created slug already exsists
        $slug_exists = ProductsModel::where('product_slug', $create_slug)->exists();
        // if it does,add its id to prevent duplicate slug else leave the slug like that
        $create_slug = $slug_exists == true ? $create_slug . '-' . $product_id : $create_slug;
        return $create_slug;
        //end product-slug cration
    }

    // public function showCategories()
    // {

    //     $current_section_id = $this->inputs['section_id'];
    //     // ['parent_id','>',0](getting all sub categories)
    //     $this->categories_from_section = CategoriesModel::where(['section_id' => $current_section_id, ['parent_id', '>', 0], 'status' => 1])->get();

    // }

    public function newproduct()
    {
        // dd('yo');
        $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewproduct = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show-add-product-modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewproduct == true ? 'Save' : 'Save Changes';

    }









    public function remove_field($index)
    {
        $product_attr = $this->product_attributes[$index];
        $product_attr->delete();
        $this->product_attributes->forget($index);
        $this->counter -= 1;

    }




    public function onCancel()
    {
        $this->dispatchBrowserEvent('hide-add-product-modal', ['is_cancel' => true]);
    }

    public function editproduct($product_id)
    {
        $this->dispatchBrowserEvent('clear-file-fields');

        $this->product_id = $product_id;
        $product = ProductsModel::where('id', $product_id)->first()->toArray();

        $this->current_product_id = $product['id'];
        $this->current_category_id = $product['category_id'];
        $this->current_supplier_id = $product['supplier_id'];

        $this->btn_text = $this->addNewproduct == true ? 'Save' : 'Save Changes';

        $this->addNewproduct = false;
        $this->dispatchBrowserEvent('show-add-product-modal');
        // triggering the show-add-product-modal to show  modal

        // $this->product_details = ProductsModel::where('id', $product_id)->first()->toArray();
        $this->inputs = $product;
        $this->inputs['image'] = $product['image'];
        // dd($this->inputs['product_images']);

    }


    public function updateproduct()
    {
        $product = ProductsModel::where('id', $this->product_id)->first()->toArray();
        if (!empty($product['image']) && empty($this->image)) {
            // if product has a picture and client is not trying to upload,
            $this->rules['image'] = '';


        } else {
            $this->rules['image'] = 'image';

        }





        // datavalidation

        $validated_data = Validator::make($this->inputs, $this->product_validation_object)->validate();
        // browser dispath here!.........

        // imagevalidation

        if ($this->image) {
            // new image uploaded

            $this->validate($this->rules, $this->message);


            if (!empty($this->inputs['image'])) {
                // there is also previous image
                Storage::disk('public')->delete($this->product_img_path . '/' . $product['image']);

            }

            $validated_data['image'] = $this->store_pic($this->image, $this->inputs['product_name']);

        }

        ProductsModel::where('id', $this->product_id)->update($validated_data);
        $this->image = '';



        $this->dispatchBrowserEvent('hide-add-product-modal', ["success_msg" => '*Refresh This Paget To See Image Update(s). Product Updated Successfully']);

    }
    // remove a temp image from images list
    public function removeImg()
    {

        $this->image = '';
        $this->dispatchBrowserEvent('clear-fieild');
    }
    // remove a db image from images list
//     public function removeDbImg($image_id){
//         $img_to_delete=ProductsGalleryModel::findOrFail($image_id);
//         Storage::disk('public')->delete('prdct_pics/'.$img_to_delete['image_name']);
//         $img_to_delete->delete();
//         $this->dispatchBrowserEvent('show-add-product-modal');
// }

    // public function store_media($media_path, $media_file, $prd_slug, $media_type, $new_product)
//     {
//         // both images and vides
//         if (!empty($media_file) && $media_type == 'product_video') {
//             // (Validation issues and cannot handle large files)
//             // store uploaded file in(prduct_videos dir)
//             $default_file_name = Storage::disk('public')->put('prdct_videos', $media_file);
//             $default_file_name = explode('/', $default_file_name)[1];
//             $file_ext = $media_file->getClientOriginalExtension();

    //             $new_file_name = 'prd_video_' . $prd_slug . "_." . $file_ext;
//             $absoulute_path = 'storage/' . $media_path . '/';
//             // override default name
//             File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);
//             $new_product['product_video'] = $new_file_name;
//         } elseif (!empty($media_file) && $media_type == 'product_pic') {
//             // store uploaded file in(prdct_pics dir)
//             foreach ($media_file as $index => $media_img) {
//                 $default_file_name = Storage::disk('public')->put('prdct_pics', $media_img);
//                 $default_file_name = explode('/', $default_file_name)[1];
//                 $file_ext = $media_img->getClientOriginalExtension();
//                 $new_file_name = 'prd_pic_' . $index . "_" . $new_product['product_name'] . "_." . $file_ext;
//                 $absoulute_path = 'storage/' . $media_path . '/';
//                 // override default name
//                 File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);
//                 ProductsGalleryModel::create([
//                     'product_id' => $new_product['id'],
//                     'index' => $index,
//                     'image_name' => $new_file_name,
//                 ]);
//             }
//         }
//         return $new_product;

    //     }
    public function get_category_section_id($category_id)
    {
        // get section id of category based on categoryid (given)
        return CategoriesModel::where(['id' => $category_id])->first()->toArray()['section_id'];

    }
    public function store_pic($media_file, $product_name)
    {
        // dd();
        if (!empty($media_file)) {
            // Get the file extension
            $file_ext = $media_file->getClientOriginalExtension();

            // Create a new file name
            $new_file_name = 'product_pic' . "_" . $product_name . "_." . $file_ext;

            // Define the storage path for product images
            $uploaded_img_path = storage_path('app/public/' . $this->product_img_path . '/'); // Adjust to storage path

            // Make sure the directory exists, if not, create it
            if (!file_exists($uploaded_img_path)) {
                mkdir($uploaded_img_path, 0755, true); // Create the directory if it doesn't exist
            }

            // Use Intervention Image to manipulate the image
            $img = Image::make($media_file);
            $img->fit(300, 300)->save($uploaded_img_path . $new_file_name);

            // Save the file to the storage/app/public/product_img_path
            $media_file->storeAs($this->product_img_path, $new_file_name, 'public'); // Ensure it is stored in public disk

            // Generate the public URL for the image
            $public_img_url = asset('storage/' . $this->product_img_path . '/' . $new_file_name);

            // Optional: Use dd() to debug the saved image path and public URL
            // dd($public_img_url);
        }

        return $new_file_name;

    }
    public function submitAddNewproduct()
    {

        if (empty($this->image)) {
            $this->rules['image'] = '';

        } else {
            $this->rules['image'] = 'image';

        }

        // datavalidation

        $validated_data = Validator::make($this->inputs, $this->product_validation_object)->validate();
        // browser dispath here!.........

        // imagevalidation

        if ($this->image) {
            // new image uploaded

            $this->validate($this->rules, $this->message);

        }
        // DD($this->inputs['supplier_id']);



        $validated_data = Validator::make($this->inputs, $this->product_validation_object)->validate();
        $product = new ProductsModel;
        $product->product_name = $validated_data['product_name'];
        $product->category_id = $validated_data['category_id'];
        $product->product_quantity = $validated_data['product_quantity'];
        $product->selling_price = $validated_data['selling_price'];
        $product->product_code = !empty($this->inputs['product_code']) ? $this->inputs['product_code'] : '';
        $product->supplier_id = !empty($this->inputs['supplier_id']) ? $this->inputs['supplier_id'] : '';
        $product->buying_price = !empty($this->inputs['buying_price']) ? $this->inputs['buying_price'] : '';
        $product->image = !empty($this->image) ? $this->store_pic($this->image, $product->product_name) : '';

        $auth_admin = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $product->uploaded_by = $auth_admin['name'];
        // $product->created_at = date('Y-m-d H:i:s');
        // $product->updated_at = date('Y-m-d H:i:s');
        // dd($product);


        if ((Auth::guard('admin')->user()) && (Auth::guard('admin')->user()['type'] == 'superadmin')) {
            $product->save();

        } else {
            dd('YOU MUST BE AN ADMIN TO DO THIS!');
        }
        $this->image = '';


        // redirect()->back();
        $this->dispatchBrowserEvent('hide-add-product-modal', ["success_msg" => 'New product Added Successfully']);

    }

    public function deleteproductConfirm($delete_prd_id)
    {
        $this->delete_prd_id = $delete_prd_id;
        $this->dispatchBrowserEvent('show_product_del_confirm');

    }

    public function confirmproductDelete()
    {
        $product_to_delete = ProductsModel::findOrFail($this->delete_prd_id);

        if (!empty($product_to_delete['image'])) {
            Storage::disk('public')->delete($this->product_img_path . '/' . $product_to_delete['image']);


        }

        $product_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'product Deleted SuccessFully!']);

    }



    public function run_search()
    {
        if (!empty($this->search)) {
            // Search for category IDs matching the search term
            $matchingCategoryIds = CategoriesModel::where('category_name', 'like', '%' . $this->search . '%')->pluck('id');

            // Find products where any field matches the search term, or where the category_id matches
            $results = ProductsModel::whereIn('category_id', $matchingCategoryIds)
                ->orWhere('product_name', 'like', '%' . $this->search . '%')
                ->orWhere('product_quantity', 'like', '%' . $this->search . '%')
                ->orWhere('selling_price', 'like', '%' . $this->search . '%')
                ->orWhere('product_code', 'like', '%' . $this->search . '%')
                ->orWhere('supplier_id', 'like', '%' . $this->search . '%')
                ->orWhere('buying_price', 'like', '%' . $this->search . '%')
                ->orWhere('uploaded_by', 'like', '%' . $this->search . '%')
                ->with(['get_supplier'])->latest()->paginate(100);


            $this->products=$results;
        } else {
            // Reset products when the search is empty
            $this->products = ProductsModel::with(['get_supplier'])->latest()->paginate(100);
        }
        // dd(   $this->products);
    }

    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // dd(Auth::guard('admin')->user());


        // Call run_search to update products based on current search
        $this->run_search();

        $categories = CategoriesModel::where(['status' => 1])->latest()->get()->toArray();
        $suppliers = SuppliersModel::latest()->get()->toArray();
       $products=$this->products;
        return view('livewire.admin.products.products-wired')->with(compact('products', 'categories', 'suppliers'));
    }



}
