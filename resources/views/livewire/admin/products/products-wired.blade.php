<div class="main-panel">
    <x-spinner />

    <div class="c
        ontent-wrapper">
        @include('admin.layout.auth_welcome')

        <div class="row">

            <div class="col-md-12 grid-margin stretch-card">

                <div class="card-body">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">PRODUCTS MANAGEMENT</h4>
                            <div class="row w-100">
                                <div class="d-flex justify-content-start w-50">
                                    <button wire:click.prevent="newproduct" class="btn btn-primary"><i
                                            class="mdi mdi-folder-plus"></i> Add New product </button>
                                </div>
                                <div class="d-flex justify-content-end w-50">
                                    <button wire:click.prevent="deleteAllproducts" class="btn btn-danger"><i
                                            class="mdi mdi-delete-sweep"></i> Clear All products </button>
                                </div>
                            </div>
                            <p class="card-description">

                            </p>
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                ID #
                                            </th>
                                            <th>
                                                Product Name
                                            </th>
                                            <th>
                                                Color
                                            </th>

                                            <th>
                                                Section
                                            </th>
                                            <th>
                                                Category
                                            </th>
                                            </th>
                                            <th>
                                                Brand
                                            </th>
                                            <th>
                                                Uploaded By
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                            <th>Actions</th>


                                        </tr>
                                    </thead>
                                    <tbody>



                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product['id'] }}</td>
                                                <td class="text-capitalize">{{ $product['product_name'] }}</td>
                                                <td class="text-capitalize">{{ $product['product_color'] }}</td>

                                                <td class="text-capitalize">
                                                    {{ $product['get_product_section']['name'] }}</td>
                                                <td class="text-capitalize">
                                                    {{ $product['get_product_category']['category_name'] }}</td>
                                                <td class="text-capitalize">{{ $product['get_product_brand']['name'] }}
                                                    @php
                                                        $vendor_id = $product['get_vendor_details']['id'];
                                                    @endphp
                                                <td class="text-capitalize">
                                                    @if ($product['admin_type'] == 'vendor')
                                                        <a href="{{ url('admin/view-vendor-details/' . $vendor_id) }}">
                                                            {{ $product['get_vendor_details']['name'] }} ({{ $product['admin_type'] }})</a>
                                                    @else
                                                        <strong> {{ ucfirst($product['get_vendor_details']['name']) }} ({{ $product['admin_type'] }})
                                                        </strong>
                                                    @endif
                                                </td>
                                                <td class="text-capitalize">
                                                    @php
                                                        $icon = $product['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';
                                                    @endphp
                                                    <span style="font-size: 20px"
                                                        class="mdi   {{ $icon }}">{{ $product['status'] == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $status_toggle_icon = $product['status'] == 1 ? 'mdi-toggle-switch text-primary' : 'mdi-toggle-switch-off';
                                                    @endphp
                                                    <i wire:click="changeproductStatus({{ $product['id'] }},{{ $product['status'] }})"
                                                        style="font-size: 30px"
                                                        class="mdi {{ $status_toggle_icon }}"></i>

                                                </td>

                                                <td>
                                                    <a wire:click.prevent="editproduct({{ $product['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>
                                                    <a wire:click.prevent="attributeproduct({{ $product['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-shape-square-plus"></a>


                                                    <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deleteproductConfirm({{ $product['id'] }})"></a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <button class="btn btn-outline-primary" onclick="makeSearchable()">Search
                                    products</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $products->links() }}
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        @include('admin.layout.footer')


        <!-- partial -->
    </div>
    <!-- Modal 1-->
    <div wire:ignore.self class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-product-modal">PRODUCT MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>
                    {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  --}}
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" class="forms-sample"
                        wire:submit.prevent={{ $addNewproduct ? 'submitAddNewproduct' : 'updateproduct ' }}>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            {{ $addNewproduct ? 'Add New product' : 'Edit product' }}
                                        </h4>
                                        <p class="card-description">

                                        </p>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input value="" wire:model.defer="inputs.product_name" type="text"
                                                class="form-control @error('product_name') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="GUCCI & GABANA">
                                            @error('product_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Color</label>
                                            <input value="" wire:model.defer="inputs.product_color" type="text"
                                                class="form-control @error('product_color') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="RED">
                                            @error('product_color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Product Weight</label>
                                            <input value="" wire:model.defer="inputs.product_weight"
                                                type="number"
                                                class="form-control @error('product_weight') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="45">
                                            @error('product_weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Price</label>
                                            <input value="" wire:model.defer="inputs.product_price"
                                                type="number"
                                                class="form-control @error('product_price') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="600">
                                            @error('product_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Discount(%)</label>
                                            <input value="" wire:model.defer="inputs.product_discount"
                                                type="number"
                                                class="form-control @error('product_discount') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="45">
                                            @error('product_discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Product's Category</label>

                                            <select
                                                class="form-control @error('category_id') bg-danger is-invalid @enderror"
                                                wire:model.defer="inputs.category_id">

                                                <option disabled> SELECT A CATEGORY</option>

                                                @foreach ($sections as $section)
                                                    <optgroup label="{{ $section['name'] }}"></optgroup>
                                                    @foreach ($section['get_category_hierarchy'] as $main_category)
                                                        <option class="fw-bold" disabled>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;
                                                            {{ $main_category['category_name'] }} </option>
                                                        @foreach ($main_category['sub_categories'] as $sub_category)
                                                            <option
                                                                @if (!empty($current_category_id) && $current_category_id == $sub_category['id']) selected @endif
                                                                value="{{ $sub_category['id'] }}"> &nbsp; &nbsp;
                                                                &nbsp;&nbsp;&nbsp;--- &nbsp;
                                                                {{ $sub_category['category_name'] }}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="fw-bold text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">


                                            <label for="exampleInputName1">Choose Product's Brand</label>

                                            <select
                                                class="form-control  @error('brand_id') bg-danger is-invalid @enderror"
                                                wire:model.defer="inputs.brand_id">
                                                <option disabled value="">CHOOSE PRODUCT'S BRAND </option>


                                                @foreach ($brands as $brand)
                                                    <option @if (!empty($current_brand_id) && $current_brand_id == $brand['id']) selected @endif
                                                        value="{{ $brand['id'] }}">{{ $brand['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>




                                            @error('brand_id')
                                                <div class="fw-bold text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputName1">Product Description</label>

                                    <textarea wire:model.defer="inputs.product_description"
                                        class="form-control @error('product_description') is-invalid @enderror"></textarea>
                                    @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Meta Title</label>
                                    <input value="" wire:model.defer="inputs.meta_title" type="text"
                                        class="form-control @error('meta_title') is-invalid @enderror


                                        id="exampleInputName1"
                                        placeholder="............">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Meta Description</label>
                                    <input value="" wire:model.defer="inputs.meta_description" type="text"
                                        class="form-control @error('meta_description') is-invalid @enderror


                                        id="exampleInputName1"
                                        placeholder=".....">
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Mea Keywords</label>
                                    <input value="" wire:model.defer="inputs.meta_keywords" type="text"
                                        class="form-control @error('meta_keywords') is-invalid @enderror


                                        id="exampleInputName1"
                                        placeholder=".....">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status</label>

                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="rad" class="form-check-input"
                                                    wire:model.defer="inputs.status" value="1"
                                                    id="membershipRadios1" value="" checked="">
                                                Active
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4">

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" name="rad" class="form-check-input "
                                                        name="stat" wire:model.defer="inputs.status"
                                                        id="membershipRadios2" value="0">
                                                    Inactive
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        @error('status')
                                            <labe class="text-danger fw-bold ml-3" style="font-size:80%">
                                                {{ $message }}</label>
                                            @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Feature Status</label>

                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="rad2" class="form-check-input"
                                                    wire:model.defer="inputs.is_featured" value="1"
                                                    id="membershipRadios1" value="" checked="">
                                                Featured
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" name="rad2" class="form-check-input"
                                                        wire:model.defer="inputs.is_featured" id="membershipRadios2"
                                                        value="0">
                                                    Not_Featured
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        @error('is_featured')
                                            <labe class="text-danger fw-bold ml-3" style="font-size:80%">
                                                {{ $message }}</label>
                                            @enderror
                                    </div>


                                </div>

                                <div class="form-group">
                                    <label for="exampleInputName1">Product's Cover Video </label>
                                    @if ($addNewproduct == false && !empty($inputs['product_video']) && !is_object($inputs['product_video']))
                                        <div class="form-group">
                                            <iframe
                                                src="{{ url('/storage/prdct_videos/' . $inputs['product_video']) }}"></iframe>

                                        </div>
                                        <div class="form-group"><a
                                                wire:click.prevent="DeleteVid({{ $product_id }})"
                                                class="text-primary">Delete This Video</a></div>
                                    @endif




                                    <div x-data="{ isUploading: false, progress: 3 }" x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false; progress=3"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <input type="file" id="prd_vid_file"
                                            class="form-control  @error('product_video') is-invalid @enderror"
                                            wire:model.defer="inputs.product_video">
                                        <div x-show="isUploading" class="progress progress-sm rounded  mt-2">
                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                role="progressbar" x-bind:style="`width:${progress }%`"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            <span class="sr-only">40% complete</span>
                                        </div>
                                        @error('product_video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>




                                </div>

                                <div class="form-group">
                                    <label for="exampleInputName1">Product's Cover Pictures(4) </label>




                                    <div x-data="{ isUploading_2: false, progress_2: 3 }" x-on:livewire-upload-start="isUploading_2 = true"
                                        x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                                        x-on:livewire-upload-error="isUploading_2 = false"
                                        x-on:livewire-upload-progress="progress_2 = $event.detail.progress">
                                        <input type="file" multiple id="prd_img_file" accept=".png,.jpeg,.jpg"
                                            class="form-control  @error('product_images.*') is-invalid @enderror  @error('product_images') is-invalid @enderror"
                                            wire:model.defer="inputs.product_images">
                                        <div x-show="isUploading_2" class="progress progress-sm rounded  mt-2">
                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                role="progressbar" x-bind:style="`width:${progress_2 }%`"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            <span class="sr-only">40% complete</span>
                                        </div>
                                        @error('product_images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('product_images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="">
                                            @if (!empty($inputs['product_images']))
                                            <ul>
                                                @foreach ($inputs['product_images'] as $index => $product_img)
                                                    <div style="position:relative;" class="mt-5 ml-3">
                                                        @if (is_object($product_img))
                                                            {{--  if object-then user is trying to upload new file  --}}

                                                            <button class="close"
                                                                style=" right:50px;
                                       position: absolute; ">
                                                                <span class="text-dark display-2"
                                                                    wire:click="removeImg({{ $index }})">&times;</span>
                                                            </button>
                                                            <li>
                                                                <div class="item d-flex align-items-center justify-content-center">
                                                                 <img class="rounded"
                                                                src="{{ $product_img->isPreviewable() ? $product_img->temporaryUrl() : '/storage/err.png' }}"
                                                                width=250 height=250>
                                                                </div>
                                                              </li>


                                                        @else
                                                            {{--  else get old one from the db  --}}

                                                                    <li>
                                                                        <div class="item d-flex align-items-center justify-content-center">
                                                                            <img class="rounded" 
                                                                            width=250 height=250
                
                                                                                src="{{ '/storage/prdct_pics/lg/' . $product_img['image_name'] }}"
                                                                                >
                                                                        </div>

                                                            </li>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </ul>
                                            <style>
                                                ul {
                                                    max-width: 300px;
                                                    margin-left: auto;
                                                    margin-right: auto;
                                                    // background-color: red;
                                                  }

                                                  ul {
                                                    min-width: 75;
                                                    padding-left: 0;
                                                    list-style: none;
                                                    display: grid;
                                                    grid-template-columns: repeat(auto-fit, minmax(75, 1fr));
                                                    gap: 1rem 1rem;
                                                  }

                                                  .item {
                                                    background-color: #4b49ac;
                                                    padding: 0.2rem;
                                                    border-radius: 1rem;
                                                    min-height: 8rem;
                                                  }

                                              </style>

                                            @endif

                                        </div>

                                    </div>




                                </div>








                                <button type="submit" class="btn btn-primary mr-2">{{ $btn_text }}</button>
                                @if ($addNewproduct == true)
                                    <button wire:click="onCancel" class="btn btn-light">Cancel</button>
                                @endif


                            </div>


                        </div>
                    </form>
                </div>
                {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>  --}}
            </div>
        </div>
    </div>
    <!-- Modal 2-->
    <div wire:ignore.self class="modal fade" id="produt-attr-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="produt-attr-modal">PRODUCT ATTRIBUTE MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>
                    {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  --}}
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> {{ 'Add Product Attribute' }}</h4>
                            <p class="card-description">

                            </p>


                            <div class="form-group">

                                <button class="w-100 btn btn-primary" wire:click="add_new_field()">Add Field</button>
                            </div>

                            @if (!empty($product_id) && !empty($product_attributes))



                                @foreach ($product_attributes as $index => $product_attribute)
                                    <div class="form-group">
                                        <input type="text"
                                            class="w-100 form-control @error('product_attributes.' . $index . '.size') is-invalid @enderror"
                                            wire:model.defer="product_attributes.{{ $index }}.size"
                                            placeholder="SIZE" style="width:90px" id="" />
                                        <div class="invalid-feedback"> @error('product_attributes.' . $index . '.size')
                                                {{ $message }}
                                            @enderror </div>
                                    </div>


                                    <div class="form-group">

                                        <input type="number"
                                            class="w-100 form-control @error('product_attributes.' . $index . '.price')  is-invalid @enderror"
                                            wire:model.defer="product_attributes.{{ $index }}.price"
                                            placeholder="PRICE" style="width:90px" id="" />
                                        <div class="invalid-feedback"> @error('product_attributes.' . $index .
                                                '.price')
                                                {{ $message }}
                                            @enderror </div>

                                        &nbsp;


                                    </div>

                                    <div class="form-group">

                                        <input type="number"
                                            class="w-100 form-control @error('product_attributes.' . $index . '.stock')  is-invalid @enderror"
                                            wire:model.defer="product_attributes.{{ $index }}.stock"
                                            placeholder="STOCK QUANTITY" style="width:90px" id="" />
                                        <div class="invalid-feedback"> @error('product_attributes.' . $index .
                                                '.stock')
                                                {{ $message }}
                                            @enderror </div>



                                    </div>


                                    <button class="mt-2 w-100 btn btn-outline-danger"
                                        wire:click="remove_field({{ $index }})">Remove Field</button>
                                    &nbsp;
                                    <div class="form-group">
                                        <label class="form-check-label" for="exampleRadios1">
                                            Attribute's Status
                                          </label>
                                        <div class="form-check">
                                            <input type="radio"  id="" name="_{{ $index }}"
                                                value="0"
                                                wire:model.defer="product_attributes.{{ $index }}.status">
                                                Active


                                            <input type="radio" name="_{{ $index }}" value="1"
                                                wire:model.defer="product_attributes.{{ $index }}.status" class="mr-2">Inactive

                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            @endif



                            <button wire:click="addNewProductAttr()" class="btn btn-primary mr-2"> Submit</button>

                            <button wire:click="onCancel" class="btn btn-light">Cancel</button>





                        </div>
                    </div>
                </div>
                {{--  <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
          </div>  --}}
            </div>
        </div>
    </div>
</div>
