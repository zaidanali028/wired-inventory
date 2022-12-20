<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Admin as AdminModel;
use App\Models\Categories as CategoriesModel;
use App\Models\Products as ProductsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MainCategoriesWired extends Component
{
    use WithFileUploads;
    // events triggered from js
    protected $listeners = ['confirm_category_delete' => 'confirmCategoryDelete', 'fileReady' => 'handleFile', 'confirm_main_category_delete_all' => 'confirmMainCategoryDeleteAll'];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // allow livewire pagination
    public $admin_details;
    public $inputs = [];
    public $product_img_path = 'product_imgs';

    public $current_category;

    public $category_details;
    public $addNewCategory = false;
    public $category_id;
    public $btn_text;
    public $delete_category_id;
    public $category_image;
    public $old_category_img;
    public $old_category_img_file_name;
    public $category_validation_array = [
        'category_name' => 'required',

        'status' => 'required'];

    public function newCategory()
    {
        $this->addNewCategory = true;
        $this->inputs = [];

        // triggering the show-add-category-modal to show  modal

        $this->dispatchBrowserEvent('show-add-category-modal');
        $this->btn_text = $this->addNewCategory ? 'Save' : 'Save Changes';

    }
    public function editMainCategory($category_id)
    {
        $this->category_id = $category_id;

        $this->addNewCategory = false;

        $this->btn_text = $this->addNewCategory == true ? 'Save' : 'Save Changes';

        $this->inputs = CategoriesModel::where('id', $category_id)->first()->toArray();

        if (!empty($this->inputs['category_image'])) {
            $this->category_image = '';
            // if there is an image for this category,we set the category_image attr to nothing so that(category_image&)
            // old_category_img doesnt crush
            $this->old_category_img = $this->inputs['category_image'];
            // $this->old_category_img will be set to empty later so the old image name is persisted using
            // $this->old_category_img_file_name so that we can delete it later
            $this->old_category_img_file_name = $this->old_category_img;

        } else {
            $this->old_category_img = '';
        }
        $this->dispatchBrowserEvent('show-add-category-modal');
// triggering the show-edit-category-modal to show  modal
    }
    public function updateMainCategory()
    {
        $validated_data = Validator::make($this->inputs, $this->category_validation_array)->validate();

        // UPDATING WITHOUT A PICTURE
        CategoriesModel::where('id', $this->category_id)->update($validated_data);

        redirect()->back();
        $this->dispatchBrowserEvent('hide-add-category-modal', ["success_msg" => 'Updated Main Category Added Successfully']);
        $this->category_image = '';
// resetting this field to default

    }

    public function onCancel()
    {
        $this->dispatchBrowserEvent('hide-add-category-modal', ['is_cancel' => true]);
    }

    public function submitAddNewMainCategory()
    {
        //  dd($this->inputs);
        $validated_data = Validator::make($this->inputs,
            $this->category_validation_array

        )->validate();

        CategoriesModel::create($validated_data);
        redirect()->back();
        $this->dispatchBrowserEvent('hide-add-category-modal', ["success_msg" => 'New Main Category Added Successfully']);

    }

    public function deleteMainCategoryConfirm($category_id)
    {
        $this->delete_category_id = $category_id;
        //  dd( $this->delete_category_id);
        $this->dispatchBrowserEvent('show_category_del_confirm');

    }
    public function del_single_category($category_id)
    {
        $category_to_delete = CategoriesModel::findOrFail($category_id);
        // $category_products=Products::findOrFail($category_id);

        // deleting all products with this id to prevent crash of app..
        $category_products = CategoriesModel::with(['get_products'])->latest()->get()->toArray();
        $category_products = $category_products[0]['get_products'];
        foreach ($category_products as $product) {
            $product_to_delete = ProductsModel::findOrFail($product['id']);

            if (!empty($product_to_delete['image'])) {
                Storage::disk('public')->delete($this->product_img_path . '/' . $product_to_delete['image']);
            }
            $product_to_delete->delete();

        }

        $category_to_delete->delete();
        $this->dispatchBrowserEvent('hide-add-category-modal', ["success_msg" => 'Category Successfully Deleted!']);

    }

    public function confirmCategoryDelete()
    {
        $this->del_single_category($this->delete_category_id);
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'Main Category Deleted SuccessFully!']);

    }
    public function deleteAllMainCategories()
    {
        $this->dispatchBrowserEvent('show_main_category_del_all_confirm');
        // invoking this to show confirm with js in customjs

    }

    //   $this->category_image will only have a value if the function below is triggered
    public function handleFile($file_data, )
    {

        $this->category_image = $file_data;
        // if (category_image) isset ,then old_category_img  attr must be nothing so that(category_image&)
        // old_category_img doesnt crush(both are using image tag)

        $this->old_category_img = '';

    }
    public function changeMainCategoryStatus($category_id, $current_status)
    {

        $new_status = $current_status == 1 ? 0 : 1;
        $category_details = CategoriesModel::query();
        $category_details = $category_details->where('id', $category_id)->update(['status' => $new_status]);
        redirect()->back();
        $this->dispatchBrowserEvent('category_status_update', ["success_msg" => 'Main Category Status Updated Successfully']);

    }

    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        $current_category_count = CategoriesModel::get()->count();

        // $categories=CategoriesModel::with(['get_section_details_from_categories','get_parent_category'])->latest()->paginate(10);
        // $categories=CategoriesModel::with(['subCategories','get_section_details_from_categories','get_parent_category'])->get()->toArray();
        $main_categories = CategoriesModel::latest()->paginate(10);
        // all parent_ids greater than 0 is a sub category
        // dd($main_categories);

        return view('livewire.admin.categories.main-categories-wired', [
            'main_categories' => $main_categories,

            'current_category_count' => $current_category_count,
        ]);
    }
}
