<?php

namespace App\Http\Livewire\Admin\Products;

// use Mtownsend\RemoveBg\RemoveBg;
// https://github.com/mtownsend5512/remove-bg
use App\Models\Admin as AdminModel;
use App\Models\Brands as BrandsModel;
use App\Models\Categories as CategoriesModel;
use App\Models\ProductAttributes as ProductAttributesModel;
use App\Models\Products as ProductsModel;
use App\Models\ProductsGallery as ProductsGalleryModel;
use App\Models\Sections as SectionsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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

    protected $paginationTheme = 'bootstrap';
    // allow livewire pagination
    public $admin_details;
    public $inputs = [];
    public $categories_from_section;

    public $product_details;
    public $addNewproduct = false;
    public $product_id;
    public $btn_text;
    public $delete_prd_id;
    public $current_product_id;
    public $current_brand_id;
    public $current_category_id;
    public $product_attributes;
    public $max_attributes = 4;
    public $counter;

    protected $listeners = ['confirm_product_delete' => 'confirmproductDelete', 'confirm_product_delete_all' => 'confirmproductDeleteAll', 'confirm_delete_only_vid' => 'confirmed_delete_only_vid'];
// WORK ON DELETING MEDIA FILES(PICTURES AND VIDEOS WHEN DELETING PRODUCTS)
    public $product_validation_object = [
        'product_name' => 'required',
        'product_color' => 'required',
        'brand_id' => 'required',

        'product_weight' => 'required|numeric',
        'product_description' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'required',
        'meta_keywords' => 'required',
        'is_featured' => 'required',
        'status' => 'required',
        'product_price' => 'required|numeric',
        'product_discount' => 'required|numeric',
        // C:\zidaan\SC\yuta-v2\vendor\livewire\livewire\src\FileUploadConfiguration.php
        // the path above @ line 108 is where file limit is(max of 100mb that is
        //  100000kbyte)(if user uploads 100mb,it wont even work)
        'product_video' => 'max:100000|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
        'category_id' => 'required',
        'product_images' => 'required|array|max:4,array|min:4',
        //    ( images array must be exactly (4))

        // storing 4 but may display 4 or 3 (4 for no-video,3 for product with video)
        'product_images.*' => 'image',
        // each value in the array must be an image

    ];

    protected $rules = [
        // rules for product attributes
        'product_attributes.*.size' => 'required',
        'product_attributes.*.price' => 'required',
        'product_attributes.*.stock' => 'required',
        'product_attributes.*.status' => 'required',
    ];
    protected $messages = [
        'product_attributes.*.size.required' => 'Please specify the size for this attribute',
        'product_attributes.*.price.required' => 'Please specify the price for this attribute',
        'product_attributes.*.stock.required' => 'Please specify the stock quantity for this attribute',

    ];
    public $customValMsgs = [
        'product_video.mimetypes' => 'We only accept mp4-video files(make sure what you provided is an mp4-video file!)',
        'product_images.mimetypes' => 'We only accept image files(make sure what you provided aint a video,a pdf or a txt file!)',
        'product_images.*.image' => 'PLEASE MAKE SURE ALL YOU PROVIDED ARE IMAGES',

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
        $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewproduct = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show-add-product-modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewproduct == true ? 'Save' : 'Save Changes';

    }

    public function deleteAllproducts()
    {
        $this->dispatchBrowserEvent('show_product_del_all_confirm');
        // invoking this to show confirm with js in customjs

    }

    public function confirmproductDeleteAll()
    {
        // deleting all sub categories
        $all_products = ProductsModel::get()->toArray();
        foreach ($all_products as $product) {
            $product_images = ProductsGalleryModel::where('product_id', $product['id'])->get()->toArray();
            if (!empty($product_images)) {
                // if it does,delete the images first....
                foreach ($product_images as $product_image) {
                    Storage::disk('public')->delete('prdct_pics/' . $product_image['image_name']);
                    ProductsGalleryModel::findOrFail($product_image['id'])->delete();

                }
                // delete video too if it exsists
                if (!empty($product['product_video'])) {
                    Storage::disk('public')->delete('prdct_videos/' . $product['product_video']);

                }

            }
        }
        ProductsModel::query()->delete();
        // delete the whole products model's items
        redirect()->back();
        $this->dispatchBrowserEvent('delete_comfirmation', ["success_msg" => 'Cleared All products Successfully']);

    }
    public function editproduct($product_id)
    {
        $this->dispatchBrowserEvent('clear-file-fields');

        $this->product_id = $product_id;
        $product = ProductsModel::where('id', $product_id)->first()->toArray();

        $this->current_product_id = $product['id'];
        $this->current_category_id = $product['category_id'];
        // dd($this->current_category_id);
        $this->current_brand_id = $product['brand_id'];
        $this->btn_text = $this->addNewproduct == true ? 'Save' : 'Save Changes';

        $this->addNewproduct = false;
        $this->dispatchBrowserEvent('show-add-product-modal');
        // triggering the show-add-product-modal to show  modal

        // $this->product_details = ProductsModel::where('id', $product_id)->first()->toArray();
        $this->inputs = ProductsModel::with(['product_imgs'])->where('id', $product_id)->first()->toArray();
        $this->inputs['product_images'] = $this->inputs['product_imgs'];
        // dd($this->inputs['product_images']);

    }

    public function attributeproduct($product_id)
    {
        $this->counter = 0;

        $this->product_id = $product_id;

        $this->product_attributes = ProductAttributesModel::all()->where('product_id', $this->product_id);

        $this->dispatchBrowserEvent('show-produt-attr-modal');
    }

    public function addNewProductAttr()
    {
        $this->validate($this->rules, $this->messages);

        foreach ($this->product_attributes as $product_attribute) {
            $product_attribute->product_id = $this->product_id;

            $product_attribute->save();
        }
        $product = ProductsModel::find($this->product_id)->first()->toArray()['product_name'];
        $this->dispatchBrowserEvent('hide-produt-attr-modal', ["success_msg" => ' Product Attributes For ' . $product . ' Has Been Updated Successfully']);

    }

    public function remove_field($index)
    {
        $product_attr = $this->product_attributes[$index];
        $product_attr->delete();
        $this->product_attributes->forget($index);
        $this->counter -= 1;

    }

    public function add_new_field()
    {

        // this helps in adding new input fields for getting additional attributes
        if ($this->counter < $this->max_attributes) {
            $this->counter += 1;
            // protected $connection = "mysql"; is required in ProductAttributesModel for this method to work

            $this->product_attributes->push(ProductAttributesModel::make());
        }

    }
    public function onCancel()
    {
        $this->dispatchBrowserEvent('hide-add-product-modal', ['is_cancel' => true]);
    }

    public function updateProductWithOrWithoutImageFiles()
    {
        $this->product_validation_object['product_images.*'] = 'image';
        $validated_data = Validator::make($this->inputs, $this->product_validation_object, $this->customValMsgs)->validate();
        $validated_data['vendor_id'] = $this->admin_details["vendor_id"];
        $validated_data['admin_type'] = $this->admin_details["type"];
        $validated_data['admin_id'] = $this->admin_details["id"];

        // checking to see if this product had images already,
        $old_images = ProductsGalleryModel::where('product_id', $this->product_id)->get()->toArray();
        $extra_small = "x_sm\\";
        $small = "sm\\";
        $medium = "md\\";
        $large = "lg\\";

        if (!empty($old_images)) {
            // if it does,delete the images first....
            foreach ($old_images as $old_image) {
                if ($old_image['index'] == 0) {
                    // delete all previous sizes of this image/first image
                    Storage::disk('public')->delete('prdct_pics/x_sm/' . $old_image['image_name']);
                    Storage::disk('public')->delete('prdct_pics/sm/' . $old_image['image_name']);
                    Storage::disk('public')->delete('prdct_pics/md/' . $old_image['image_name']);
                    ProductsGalleryModel::findOrFail($old_image['id'])->delete();

                }
                Storage::disk('public')->delete('prdct_pics/lg/' . $old_image['image_name']);
                ProductsGalleryModel::findOrFail($old_image['id'])->delete();

            }
        }
        $validated_data['product_slug'] = $this->create_slug($validated_data['product_name'], $this->product_id);

        foreach ($validated_data['product_images'] as $index => $media_img) {
            // storing newly uploaded pictures
            // $default_file_name = Storage::disk('public')->put('prdct_pics', $media_img);
            // $default_file_name = explode('/', $default_file_name)[1];
            // File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);

            $file_ext = $media_img->getClientOriginalExtension();
            $new_file_name = 'prd_pic_' . $index . "_" . $validated_data['product_name'] . "_." . $file_ext;
            $absoulute_path = 'storage/' . "prdct_pics" . '/';
            $uploaded_img_path = public_path() . '\\storage\\' . 'prdct_pics\\' . '\\';

            // $lg = Image::make($media_img)->fit(1100, 1100)->save($uploaded_img_path . $large . $new_file_name);
            $path = $uploaded_img_path . $large . $new_file_name;
            Image::canvas(1100, 1100, '#b53717')->insert($media_img)->save($path);

            if ($index == 0) {
                // meaning is the first new image to be uploaded
                $xs = Image::make($media_img)->fit(100, 91)->save($uploaded_img_path . $extra_small . $new_file_name);
                $sm = Image::make($media_img)->fit(440, 440)->save($uploaded_img_path . $small . $new_file_name);
                $md = Image::make($media_img)->fit(600, 600)->save($uploaded_img_path . $medium . $new_file_name);
            }

            // override default name
            ProductsGalleryModel::create([
                'product_id' => $this->product_id,
                'index' => $index,
                'image_name' => $new_file_name,
            ]);
        }

// can now remove $validated_data['product_images'] and update db
        unset($validated_data['product_images']);
        $validated_data['section_id'] = $this->get_category_section_id($validated_data['category_id']);

        ProductsModel::where('id', $this->product_id)->update($validated_data);

    }

    public function upload_updated_video($validated_data)
    {
        // dd($validated_data);
        $video_file = $validated_data['product_video'];
        $prd_slug = $validated_data['product_slug'];

        if (!empty($video_file) && !is_string($video_file)) {
            // confirming video file

            $old_video = ProductsModel::where('id', $this->product_id)->first()->toArray()['product_video'];
            if (!empty($old_video)) {
                // check if there is an old video,delete it before adding a new one

                Storage::disk('public')->delete('prdct_videos/' . $old_video);
                // name will not be cleared as it will be overwritten
            }

            $media_file = $video_file;
            $default_file_name = Storage::disk('public')->put('prdct_videos', $media_file);
            $default_file_name = explode('/', $default_file_name)[1];
            $file_ext = $media_file->getClientOriginalExtension();

            $new_file_name = 'prd_video_' . $prd_slug . "_." . $file_ext;
            $absoulute_path = 'storage/prdct_videos/';
            // override default name
            File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);
            // dd($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);

            $validated_data['product_video'] = $new_file_name;
            // dd($validated_data['product_video']);
            return $validated_data;

        }
    }

    public function updateproduct()
    {

        // dd($this->inputs['product_video']);
        if (is_string($this->inputs['product_video'])) {
            // it will only be a string if $this->inputs['product_video'] has a vide file name example("prd_video_this_.mkv" or " ")
            $this->product_validation_object['product_video'] = "";
        } else {
            // $this->product_validation_object['product_video'] = "max:100000|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi";
            $this->product_validation_object['product_video'] = "max:100000|mimetypes:video/mp4";
        }
        $product = ProductsModel::with(['product_imgs'])->where('id', $this->product_id)->first()->toArray();
        if (!empty($this->inputs['product_images'])) {
            // if user specifies files in the product_images array,
            if ($product['product_imgs'] == $this->inputs['product_images']) {
                // dd($product['product_imgs'],$this->inputs['product_images']);
                // if the product_images from the db and the new ome user specified
                //  are equal,then the user wants to maintain the old pictures
                $this->product_validation_object['product_images.*'] = "";
                $validated_data = Validator::make($this->inputs, $this->product_validation_object, $this->customValMsgs)->validate();
                $validated_data['product_slug'] = $this->create_slug($validated_data['product_name'], $this->product_id);
                // dd($validated_data);
                unset($validated_data['product_images']);
                // the above code prevents the site from breaking when updating because  'product_images' is
                // not really part of the products model

                $validated_data['vendor_id'] = $this->admin_details["vendor_id"];
                $validated_data['admin_type'] = $this->admin_details["type"];
                $validated_data['admin_id'] = $this->admin_details["id"];
                $validated_data['section_id'] = $this->get_category_section_id($validated_data['category_id']);

                if (!empty($validated_data['product_video']) && is_object($validated_data['product_video'])) {

                    // if user specified a file (for product video)
                    // how it is detected?
                    // 1.the key ['product_videpo] in the $validated_data variable will be a livewirefileupload object
                    // 2. it wont be empty
                    // dd($validated_data);
                    $validated_data = $this->upload_updated_video($validated_data);
                    // dd( $validated_data );
                }

                // so  no validation on images if images already exsists else

                ProductsModel::where('id', $this->product_id)->update($validated_data);
                // video not added(yet)

            } else {
                // if they aint the same,new data was given and needs validation
                $this->updateProductWithOrWithoutImageFiles();
                // product is not empty but has  files

            }

        } else {
            // product_images are empty
            $this->updateProductWithOrWithoutImageFiles();
            // product is  empty without image files
        }
        // below is commented because no matter what,a product must have a picture when uploading it

        if (!empty($this->inputs['product_video']) && is_object($this->inputs['product_video'])) {
            $validated_data = [];
            // dd($this->inputs);
            $validated_data['product_video'] = $this->inputs['product_video'];
            $validated_data['product_slug'] = $this->create_slug($this->inputs['product_name'], $this->product_id);

            $validated_data = $this->upload_updated_video($validated_data);

        }
        $this->dispatchBrowserEvent('hide-add-product-modal', ["success_msg" => ' Product Updated Successfully']);

    }
    // remove a temp image from images list
    public function removeImg($image_index)
    {
        unset($this->inputs['product_images']
            [$image_index]);
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
    public function submitAddNewproduct()
    {

        $validated_data = Validator::make($this->inputs, $this->product_validation_object, $this->customValMsgs)->validate();

        $validated_data['section_id'] = $this->get_category_section_id($validated_data['category_id']);

        $validated_data['vendor_id'] = $this->admin_details["vendor_id"];
        $validated_data['admin_type'] = $this->admin_details["type"];
        $validated_data['admin_id'] = $this->admin_details["id"];
        $validated_data['product_video'] = "";
        $validated_data['product_slug'] = "";
        // dd($validated_data);
        $new_product = ProductsModel::create($validated_data);
        $prd_slug = $this->create_slug($new_product->product_name, $new_product->id);
        $new_product->product_slug = $prd_slug;
        $product_video = !empty($this->inputs['product_video']) ? $this->inputs['product_video'] : '';
        $product_images = !empty($this->inputs['product_images']) ? $this->inputs['product_images'] : "";
        $media_stored = $this->store_media('prdct_videos', $product_video, $prd_slug, 'product_video', $new_product);
        $media_stored = $this->store_media('prdct_pics', $product_images, $prd_slug, 'product_pic', $media_stored);
        $media_stored->save();

        redirect()->back();
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
        $product_data = ProductsGalleryModel::where('product_id', $this->delete_prd_id)->get()->toArray();
        if (!empty($product_images)) {
            // if it does,delete the images first....
            foreach ($product_images as $product_image) {
                Storage::disk('public')->delete('prdct_pics/' . $product_image['image_name']);
                ProductsGalleryModel::findOrFail($product_image['id'])->delete();

            }
        }
        if (!empty($product_to_delete['product_video'])) {
            Storage::disk('public')->delete('prdct_videos/' . $product_to_delete['product_video']);

        }

        $product_to_delete->delete();
        redirect()->back();

        $this->dispatchBrowserEvent('delete_comfirmation', ['success_msg' => 'product Deleted SuccessFully!']);

    }

    public function changeproductStatus($product_id, $current_status)
    {

        $new_status = $current_status == 1 ? 0 : 1;
        $product_details = ProductsModel::query();
        $product_details = $product_details->where('id', $product_id)->update(['status' => $new_status]);
        redirect()->back();
        $this->dispatchBrowserEvent('product_status_update', ["success_msg" => 'Product Status Updated Successfully']);

    }

    public function image_bg_handler($image_full_path,$image_partial_path)
    {
        // dd($var);
        $process = new Process(['python', public_path() . '/image_processor.py', $image_full_path,$image_partial_path]);

        $process->run();

// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        dd($process->getOutput());
    }

    public function store_media($media_path, $media_file, $prd_slug, $media_type, $new_product)
    {
        // both images and vides
        if (!empty($media_file) && $media_type == 'product_video') {
            // (Validation issues and cannot handle large files)
            // store uploaded file in(prduct_videos dir)
            $default_file_name = Storage::disk('public')->put('prdct_videos', $media_file);
            $default_file_name = explode('/', $default_file_name)[1];
            $file_ext = $media_file->getClientOriginalExtension();

            $new_file_name = 'prd_video_' . $prd_slug . "_." . $file_ext;
            $absoulute_path = 'storage/' . $media_path . '/';
            // override default name
            File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);
            $new_product['product_video'] = $new_file_name;
        } elseif (!empty($media_file) && $media_type == 'product_pic') {

            $extra_small = "x_sm\\";
            $small = "sm\\";
            $medium = "md\\";
            $large = "lg\\";
            // what is above is path to image dimensions folder(it must be created for it to work)
            $uploaded_img_path = public_path() . '\\storage\\' . $media_path . '\\';

            // store uploaded file in(prdct_pics dir)
            foreach ($media_file as $index => $media_img) {
                $file_ext = $media_img->getClientOriginalExtension();
                $new_file_name = 'prd_pic_' . $index . "_" . $new_product['product_name'] . "_." . $file_ext;

                if ($index == 0) {

                    // The first image will be used in multiple places (in different dimensions)

                    $xs = Image::make($media_img)->fit(100, 91)->save($uploaded_img_path . $extra_small . $new_file_name);

                    $sm = Image::make($media_img)->fit(440, 440)->save($uploaded_img_path . $small . $new_file_name);
                    $md = Image::make($media_img)->fit(600, 600)->save($uploaded_img_path . $medium . $new_file_name);
                    $this->image_bg_handler($uploaded_img_path . $medium.$new_file_name,$uploaded_img_path . $medium);


                    $lg = Image::make($media_img)->fit(1100, 1100)->save($uploaded_img_path . $large . $new_file_name);

                    // $default_file_name = Storage::disk('public')->put('prdct_pics', $media_img);
                    // $default_file_name = explode('/', $default_file_name)[1];
                    // $absoulute_path = 'storage/' . $media_path . '/';
                    // // override default name
                    // File::move($absoulute_path . $default_file_name, $absoulute_path . $new_file_name);

                } else {
                    // for product's images gallery
                    $img = Image::make($media_img);
                    $lg = $img->fit(1100, 1100)->save($uploaded_img_path . $large . $new_file_name);

                }
                ProductsGalleryModel::create([
                    'product_id' => $new_product['id'],
                    'index' => $index,
                    'image_name' => $new_file_name,
                ]);
            }
        }
        return $new_product;

    }

    public function render()
    {
        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        // dd(Auth::guard('admin')->user());

        $products = ProductsModel::with(['get_product_section', 'get_product_category', 'get_product_brand', 'get_vendor_details'])->latest()->paginate(10);
        // $products=ProductsModel::with(['get_product_section','get_product_category','get_product_brand','get_vendor_details'])->latest()->get()->toArray();
        // dd($products);
        $sections = SectionsModel::with('get_category_hierarchy')->where('status', 1)->latest()->get()->toArray();
        // dd($sections);
        $categories = CategoriesModel::where('status', 1)->latest()->get();
        $brands = BrandsModel::where('status', 1)->latest()->get();
        // dd($sections);

        return view('livewire.admin.products.products-wired')->with(compact('products', 'sections', 'categories', 'brands'));
    }

}
