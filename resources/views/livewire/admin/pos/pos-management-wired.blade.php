<div class="main-panel">
    <x-spinner />


    <div class="c
        fontent-wrapper">
        @include('admin.layout.auth_welcome')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-capitalize">
                {{ Session::get('page') }}

            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a >Home</a></li>
                <li aria-current="page" class="breadcrumb-item  ">
                    {{ Session::get('page') }}
                </li>
            </ol>
        </div>

        <div id="container-wrapper" class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800 text-capitalize">
                    {{ Session::get('page') }}

                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a >Home</a></li>
                    <li aria-current="page" class="breadcrumb-item  ">
                        {{ Session::get('page') }}
                    </li>
                </ol>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 font-weight-bold text-primary">POINT OF SALE</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="font-size: 12px;">
                                @if ($pos_item_count > 0)
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Unit</th>
                                                <th>Total(In GH₵)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pos_products as $pos_product)
                                                <tr>
                                                    <td>{{ $pos_product->product_name }}</td>
                                                    <td style="min-width:200px">
                                                        <div
                                                            class=" input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                            <span
                                                                class="input-group-btn input-group-prepend

                                                        "><button
                                                                    wire:click.prevent="decrease_from_cart({{ $pos_product->product_id }})"
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm bootstrap-touchspin-down
                                                            @if ($pos_product->product_quantity <= 1) disabled @endif
                                                            ">-</button></span>
                                                            <input type="text" readonly="readonly"
                                                                value="{{ $pos_product->product_quantity }}"<"
                                                                class="form-control" style="width: 5px;"> <span
                                                                class="input-group-btn input-group-append"><button
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm bootstrap-touchspin-up"
                                                                    wire:click.prevent="add_to_cart({{ $pos_product->product_id }})">+</button></span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $pos_product->product_price }}</td>
                                                    <td>₵ {{ $pos_product->sub_total }} </td>
                                                    <td><a wire:click.prevent="cart_item_delete({{ $pos_product->product_id }})"
                                                            class="btn btn-sm btn-danger" style="color: white;">X</a>
                                                    </td>
                                                </tr>
                                                @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>
                                            @endforelse

                                        </tbody>
                                    </table>

                                @endif
                            </div>
                        </div>


                        <div class="card-footer">
                            <div class="order-md-2 mb-4">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Total Quantity</h6>
                                        </div> <span class="text-muted">{{ $total_qty }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Sub Total</h6>
                                        </div> <span class="text-muted">₵ {{ $sub_total }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Vat</h6>
                                        </div> <span class="text-muted">0%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between bg-light">
                                        <div class="text-success">
                                            <h6 class="my-0">Total (GH₵)</h6>
                                        </div> <span class="text-success">₵ {{ $total }}</span>
                                    </li>
                                </ul>

                                <form wire:submit.prevent='process_order'>
                                    <div class="form-group" wire:ignore ><label for="exampleFormControlSelect1">Select
                                            Customer</label>
                                            <!-- add some CSS to style the select dropdown and search field -->



                                        <select  class="form-control
                                        {{--  @error('customer_id')
                                        bg-danger is-invalid
                                        @enderror  --}}
                                        "wire:model.defer="inputs.customer_id"  id="select2">
                                            <option selected value="" >*SELECT A CUSTOMER</option>

                                            @forelse ($customers as $customer )
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @empty

                                                <option > No Data To Show!</option>



                                            @endforelse

                                                                                                    </select>
                                        {{--  @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror  --}}
                                    </div>
                                    <div class="form-group"><label for="exampleFormControlInput1">(GH₵) Pay</label> <input

                                            type="text" wire:model.debounce.500ms="inputs.pay" id="exampleFormControlInput1" class="form-control
                                            @error('pay') is-invalid @enderror
                                            ">
                                            @error('pay')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        </div>
                                        <div class="form-group"><label for="exampleFormControlInput1">(GH₵) Due</label> <input

                                            type="text" wire:model.defair="inputs.due" id="exampleFormControlInput1" class="form-control
                                            @error('due') is-invalid @enderror
                                            ">
                                            @error('due')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        </div>
                                        <div class="form-group"><label for="exampleFormControlInput1">(GH₵) Discount</label> <input

                                            type="text" wire:model.debounce.500ms="inputs.discount" id="exampleFormControlInput1" class="form-control
                                            @error('discount') is-invalid @enderror
                                            ">
                                            @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        </div>

                                    <div class="form-group"><label for="exampleFormControlSelect2">Pay By</label>
                                        <select  class="form-control
                                        @error('payBy')
                                        bg-danger is-invalid
                                        @enderror
                                        " wire:model.defer="inputs.payBy">
                                            <option selected value="">*SELECT A payment method</option>
                                            <option value="Cheque" >Cheque</option>
                                            <option value="Hand Cash">Hand Cash</option>
                                            <option value="Momo Transfer">Momo Transfer</option>


                                                                                                    </select>

                                        @error('payBy')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 font-weight-bold text-primary">Products</h5> <input type="text"
                                placeholder="Search" class="form-control" style="width: 300px;"
                                wire:model.debounce.1s="search">
                            {{--  {{ $search }}  --}}
                        </div>
                        <ul id="myTab" role="tablist" class="nav nav-tabs">
                            <li role="presentation" wire:ignore class="nav-item"><a id="home-tab" data-toggle="tab"
                                    href="#home" role="tab" aria-controls="home" aria-selected="true"
                                    class="nav-link active" wire:click.prevent='home_tab_clicked'>Home</a></li>
                            @forelse ($categories as $category)
                                <li role="presentation" wire:ignore class="nav-item"><a
                                        wire:click.prevent="getCategoryProducts({{ $category['id'] }})"
                                        id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false"
                                        class="nav-link">{{ $category['category_name'] }}</a></li>
                                        @empty

                                            <li colspan> No Data To Show!</li>

                                        @endforelse
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div wire:ignore.self id="home" role="tabpanel" aria-labelledby="home-tab"
                                class="tab-pane  fade show active">
                                <div class="card-body ">
                                    <div class="row">
                                        @if(!empty($products))
                                        @forelse ($products as $product)
                                            <div wire:click.prevent="add_to_cart({{ $product['id'] }})"
                                                class="col-lg-3 col-md-3 col-sm-6 col-6 m-4">
                                                <div class="

                                                card"
                                                    style="align-items: center; margin-bottom: 5px;">
                                                    <button
                                                        class="btn btn-sm shadow-lg p-3 mb-5 bg-white rounded  @if ($clicked_product_id == $product['id']) border border-primary @endif"><img
                                                            id="image_size"
                                                            @php
$product_img= !empty($product['image']) ?'/storage/'.$product_img_path.'/' . $product['image'] : '' @endphp
                                                            src="{{ $product_img }}" alt="PRODUCT IMAGE"
                                                            class="card-img-top rounded">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-center">
                                                                {{ $product['product_name'] }} -
                                                                ₵{{ $product['selling_price'] }}</h5>
                                                            <td>
                                                                @if ($product['product_quantity'] >= 1)
                                                                    <span class="badge badge-success">Available <span
                                                                            class="badge badge-light">{{ $product['product_quantity'] }}</span></span>
                                                                @else
                                                                    <span class="badge badge-danger">Not Available
                                                                        <span
                                                                            class="badge badge-light">{{ $product['product_quantity'] }}</span></span>
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            @empty
                                           <p>No Data To Show!</p>
                                        @endforelse
                                        @else
                                        <p>No Data To Show!</p>

                                        @endif


                                    </div>
                                </div>
                            </div>
                            <div id="profile" role="tabpanel" wire:ignore.self aria-labelledby="profile-tab"
                                class="tab-pane fade">
                                <div class="card-body">
                                    <div class="row">
                                        @if (!empty($category_items))
                                            @forelse ($category_items as $cat_product)
                                                <div wire:click.prevent="add_to_cart({{ $cat_product['id'] }})"
                                                    class="col-lg-3 col-md-3 col-sm-6 col-6 m-4">
                                                    <div class="card"
                                                        style="align-items: center; margin-bottom: 10px;">
                                                        <button
                                                            class="btn btn-sm shadow-lg p-3 mb-5 bg-white rounded @if ($clicked_product_id == $cat_product['id']) border border-primary @endif"><img
                                                                id="image_size"
                                                                @php
$cat_product_img= !empty($cat_product['image']) ?'/storage/'.$product_img_path.'/' . $cat_product['image'] : '' @endphp
                                                                src="{{ $cat_product_img }}" alt="PRODUCT IMAGE"
                                                                class="card-img-top rounded">
                                                            <div class="card-body">
                                                                <h5 class="card-title text-center">
                                                                    {{ $cat_product['product_name'] }} -
                                                                    ₵ {{ $cat_product['selling_price'] }}</h5>
                                                                <td>
                                                                    @if ($cat_product['product_quantity'] >= 1)
                                                                        <span class="badge badge-success">Available
                                                                            <span
                                                                                class="badge badge-light">{{ $cat_product['product_quantity'] }}</span></span>
                                                                    @else
                                                                        <span class="badge badge-danger">Not Available
                                                                            <span
                                                                                class="badge badge-light">{{ $cat_product['product_quantity'] }}</span></span>
                                                                    @endif
                                                                </td>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                                @empty
                                            <p>No Data To Show!</p>
                                            @endforelse
                                            @else
                                            <p>No Data To Show!</p>
                                        @endif
                                    </div>
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

</div>
