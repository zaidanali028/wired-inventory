<div class="main-panel">
    <x-spinner />

    <div class="c
        ontent-wrapper">
        @include('admin.layout.auth_welcome')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-capitalize">
                {{ Session::get('page') }}

            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a>Home</a></li>
                <li aria-current="page" class="breadcrumb-item  ">
                    {{ Session::get('page') }}
                </li>
            </ol>
        </div>

        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">Product List</h2> <a
                                    wire:click.prevent="newproduct" class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Add Product</a>

                            </div>
                            <div class="table-responsive">
                                <table id='' class=" table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Status #
                                            </th>
                                            <th>
                                                Product Quantity
                                            </th>
                                            <th>
                                                Product Name
                                            </th>
                                            <th>
                                                Cateogory
                                            </th>
                                            <th>
                                                Supplier
                                            </th>

                                            <th>
                                                Selling Price
                                            </th>

                                            @if ($admin_details['type'] == 'admin')
                                                <th>
                                                    Buying Price
                                                </th>
                                            @endif

                                            </th>
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Uploaded By
                                            </th>

                                            <th>Actions</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <div class="row">
                                            <div class="col-md-9"></div>
                                            <div class="col-md-3 ">
                                                <form wire:submit.prevent='run_search'>
                                                    <input wire:model.defer="search"
                                                        class="mt-3 mb-3 mr-5 form-control rounded-pill" type="search"
                                                        placeholder="Search" aria-label="Search">
                                                    <button type="button" wire:click.prevent="run_search" class="btn btn-outline-primary">Search
                                                        Products</button>
                                                </form>




                                            </div>
                                        </div>

                                        @forelse ($products as $product)
                                            <tr>
                                                <td>
                                                    @if (intVal($product['product_quantity']) < 1)
                                                        <p class="badge badge-danger"> {{ 'Out Of Stock!' }}</p>
                                                    @elseif(intVal($product['product_quantity']) <= 10)
                                                        <p class="badge badge-warning"> {{ 'Averagely Stocked' }}</p>
                                                    @else
                                                        <p class="badge badge-success"> {{ 'Still Stocked' }} </p>
                                                    @endif
                                                </td>
                                                <td class="text-capitalize">{{ $product['product_quantity'] }}</td>

                                                <td class="text-capitalize">{{ $product['product_name'] }}</td>
                                                <td class="text-capitalize">
                                                    {{ $product['get_category']['category_name'] }}</td>
                                                <td class="text-capitalize">
                                                    {{ !empty($product['get_supplier']) ? $product['get_supplier']['name'] : 'No Supplier!' }}
                                                </td>

                                                <td class="text-capitalize">{{ $product['selling_price'] }}</td>
                                                @if ($admin_details['type'] == 'admin')
                                                    <td class="text-capitalize">{{ $product['buying_price'] }}</td>
                                                @endif

                                                <td>
                                                    @if (!empty($product['image']))
                                                        <img src="{{ asset('storage/' . $product_img_path . '/' . $product['image']) }}"
                                                            alt="image">
                                                    @elseif(empty($product['image']))
                                                        <img src="{{ asset('/storage/default_product.jpg') }}"
                                                            alt="profile" />
                                                    @endif



                                                </td>
                                                <td class="text-capitalize">{{ $product['uploaded_by'] }}</td>




                                                <td>
                                                    <a wire:click.prevent="editproduct({{ $product['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>



                                                    {{-- <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deleteproductConfirm({{ $product['id'] }})"></a> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>


                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $products->links() }}
                                </div>
                            </div>
                            <div class="card-footer"></div>
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
                            <div class="col-md-12 ">
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
                                            <label for="exampleInputName1">Product's Quantity</label>
                                            <input value="" wire:model.defer="inputs.product_quantity"
                                                type="number"
                                                class="form-control @error('product_quantity') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="2000">
                                            @error('product_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Selling Price</label>
                                            <input value="" wire:model.defer="inputs.selling_price" type="text"
                                                class="form-control @error('selling_price') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="5500">
                                            @error('selling_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Buying Price [YOU CAN CHOOSE NOT TO
                                                SPECIFY]</label>
                                            <input value="" wire:model.defer="inputs.buying_price"
                                                type="text"
                                                class="form-control @error('buying_price') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="5000">
                                            @error('buying_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Product's Code [LEAVE BLANK IF NONE]</label>
                                            <input value="" wire:model.defer="inputs.product_code"
                                                type="number"
                                                class="form-control @error('product_code') is-invalid @enderror


                                                    id="exampleInputName1"
                                                placeholder="product_2343">
                                            @error('product_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">



                                                <div class="col-md-12">


                                                    <!---->
                                                    <div x-data="{ isUploading_2: false, progress_2: 3 }"
                                                        x-on:livewire-upload-start="isUploading_2 = true"
                                                        x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                                                        x-on:livewire-upload-error="isUploading_2 = false"
                                                        x-on:livewire-upload-progress="progress_2 = $event.detail.progress">
                                                        <div class="custom-file" style="margin-top: 16px;"><input
                                                                wire:model.defer="image" type="file"
                                                                accept=".png,.jpeg,.jpg" id="customFile"
                                                                class="custom-file-input @error('image')
                                                                        is-invalid

                                                                        @enderror">
                                                            @error('image')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror

                                                            <label for="customFile" class="custom-file-label">Product
                                                                Image [CAN BE EMPTY] </label>
                                                        </div>
                                                        <div x-show="isUploading_2"
                                                            class="progress progress-sm rounded  mt-2"
                                                            style="display: none;">
                                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                                role="progressbar"
                                                                x-bind:style="`width:${progress_2 }%`"
                                                                aria-valuenow="70" aria-valuemin="0"
                                                                aria-valuemax="100" style="width:3%"></div>
                                                            <span class="sr-only">40% complete</span>
                                                        </div>
                                                        <div class="d-flex justify-content-around">

                                                            @if (!empty($image) || !empty($inputs['image']))
                                                                <ul>


                                                                    <div style="position:relative;" class="mt-5 ml-3">
                                                                        @if (isset($image) && is_object($image))
                                                                            <button class="close"
                                                                                style=" right:50px;
                                       position: absolute; ">
                                                                                <span class="text-white display-2"
                                                                                    wire:click.prevent="removeImg()">&times;</span>
                                                                            </button>

                                                                            <li>
                                                                                <div
                                                                                    class="item d-flex align-items-center justify-content-center">

                                                                                    <img class="rounded"
                                                                                        src="{{ $image->isPreviewable() ? $image->temporaryUrl() : '/storage/err.png' }}"
                                                                                        width=250 height=230>
                                                                                </div>
                                                                            </li>
                                                                        @elseif(!empty($inputs['image']))
                                                                            <li>
                                                                                <div
                                                                                    class="item d-flex align-items-center justify-content-center">
                                                                                    <img class="rounded" width=250
                                                                                        height=250
                                                                                        src="{{ '/storage/' . $product_img_path . '/' . $inputs['image'] }}">
                                                                                </div>

                                                                            </li>
                                                                        @endif
                                                                    </div>
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





                                                        <div class="d-flex justify-content-around">



                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">


                                            <label for="exampleInputName1">Choose Product's Category</label>

                                            <select
                                                class="form-control  @error('category_id') bg-danger is-invalid @enderror"
                                                wire:model.defer="inputs.category_id">
                                                <option value="">* CHOOSE PRODUCT'S CATEGORY</option>



                                                @forelse ($categories as $category)
                                                    <option @if (!empty($current_category_id) && $current_category_id == $category['id']) selected @endif
                                                        value="{{ $category['id'] }}">
                                                        {{ $category['category_name'] }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>




                                            @error('category_id')
                                                <div class="fw-bold text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">


                                            <label for="exampleInputName1">Choose Product's Supplier [LEAVE BLANK IF
                                                NONE]</label>

                                            <select
                                                class="form-control  @error('supplier_id') bg-danger is-invalid @enderror"
                                                wire:model.defer="inputs.supplier_id">
                                                <option value="">Choose Product's Supplier </option>


                                                @foreach ($suppliers as $supplier)
                                                    <option @if (!empty($current_supplier_id) && $current_supplier_id == $supplier['id']) selected @endif
                                                        value="{{ $supplier['id'] }}">{{ $supplier['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>




                                            @error('suppier_id')
                                                <div class="fw-bold text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">{{ $btn_text }}</button>

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

</div>
