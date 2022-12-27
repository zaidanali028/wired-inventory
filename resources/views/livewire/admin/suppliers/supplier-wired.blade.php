<div class="main-panel">
    <x-spinner />

    <div class="content-wrapper">
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


        <div class="row">

            {{--  <div class="col-md-12 grid-margin stretch-card">

                <div class="card-body">





                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">supplierS MANAGEMENT</h4>
                            <div class="row w-100">
                                <div class="d-flex justify-content-start w-50">
                                    <button wire:click.prevent="newsupplier" class="btn btn-primary"><i
                                            class="mdi mdi-folder-plus"></i> Add New supplier </button>
                                </div>

                            </div>
                            <p class="card-description">

                            </p>
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">

                                    <thead>
                                        <tr>

                                            <th>
                                                Name #
                                            </th>
                                            <th>
                                                Shop Name
                                            </th>
                                            <th>
                                                phone
                                            </th>
                                            <th>
                                                E-mail
                                            </th>
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                            <th>
                                                Address
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier_by_type)

                                                <tr>

                                                    <td class="py-1">
                                                        {{ $supplier_by_type['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ !(empty($supplier_by_type['shopName']))?$supplier_by_type['shopName']:'' }}

                                                    </td>
                                                    <td>
                                                        {{ $supplier_by_type['phone'] }}

                                                    </td>
                                                    <td>
                                                        {{ $supplier_by_type['email'] }}

                                                    </td>
                                                    <td>
                                                        @if (!empty($supplier_by_type['photo']))
                                                            <img src="{{ asset('storage/'.$supplier_img_path.'/' . $supplier_by_type['photo']) }}"
                                                                alt="image">
                                                        @elseif(empty($supplier_by_type['photo']))
                                                            <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                                                alt="profile" />
                                                        @endif




                                                    </td>
                                                    <td>
                                                        <a wire:click.prevent="editsupplier({{ $supplier_by_type['id'] }})"
                                                            style="font-size: 20px"
                                                            class=" mdi mdi-pencil-box-outline"></a>


                                                        <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                            wire:click.prevent="deletesupplierConfirm({{ $supplier_by_type['id'] }})"></a>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $icon = $supplier_by_type['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';

                                                        @endphp
                                                        <span style="font-size: 20px"
                                                       >{{ $supplier_by_type['address'] }}
                                                        </span>

                                                    </td>


                                                </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                                <button class="btn btn-outline-primary" onclick="makeSearchable()">Search
                                    suppliers</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $suppliers->links() }}
                                </div>



                        </div>
                    </div>

                </div>

            </div>  --}}
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">Suppliers List</h2> <a
                                    wire:click.prevent="newsupplier" class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Add Supplier</a>
                            </div>
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">

                                    <thead>
                                        <tr>

                                            <th>
                                                Name #
                                            </th>
                                            <th>
                                                Shop Name
                                            </th>
                                            <th>
                                                phone
                                            </th>
                                            <th>
                                                E-mail
                                            </th>
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                            <th>
                                                Address
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier_by_type)
                                            <tr>

                                                <td class="py-1">
                                                    {{ $supplier_by_type['name'] }}
                                                </td>
                                                <td>
                                                    {{ !empty($supplier_by_type['shopName']) ? $supplier_by_type['shopName'] : '' }}

                                                </td>
                                                <td>
                                                    {{ $supplier_by_type['phone'] }}

                                                </td>
                                                <td>
                                                    {{ $supplier_by_type['email'] }}

                                                </td>
                                                <td>
                                                    @if (!empty($supplier_by_type['photo']))
                                                        <img src="{{ asset('storage/' . $supplier_img_path . '/' . $supplier_by_type['photo']) }}"
                                                            alt="image">
                                                    @elseif(empty($supplier_by_type['photo']))
                                                        <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                                            alt="profile" />
                                                    @endif




                                                </td>
                                                <td>
                                                    <a wire:click.prevent="editsupplier({{ $supplier_by_type['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>


                                                    <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deletesupplierConfirm({{ $supplier_by_type['id'] }})"></a>
                                                </td>
                                                <td>
                                                    @php
                                                        $icon = $supplier_by_type['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';

                                                    @endphp
                                                    <span style="font-size: 20px">{{ $supplier_by_type['address'] }}
                                                    </span>

                                                </td>


                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <button class="ml-2 btn btn-outline-primary" onclick="makeSearchable()">Search
                                    suppliers</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $suppliers->links() }}
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
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="add-supplier-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-Supplier-modal">supplier MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></i>

                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body p-0">
                            <h4 class="card-title"> Add New supplier</h4>

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="login-form">
                                        <div class="text-center">

                                        </div>
                                        <form enctype="multipart/form-data"
                                            wire:submit.prevent={{ $addNewsupplier ? 'submitaddNewSupplier' : 'updatesupplier ' }}>


                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            @endif


                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-12"><input type="text"
                                                            id="exampleInputFirstName" wire:model.defer="inputs.name"
                                                            placeholder="Enter Supplier Full Name"
                                                            class="form-control @error('name') is-invalid @enderror">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror

                                                        <!---->
                                                    </div>

                                                    <!---->
                                                </div>
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12"><input type="email" id="exampleInputFirstName"
                                                    wire:model.defer="inputs.email"
                                                    placeholder="Enter Supplier  Email"
                                                    class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <!---->
                                            </div>

                                            <!---->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <input type="text" id="exampleInputDate"
                                                    wire:model.defer="inputs.address"
                                                    placeholder="Enter Supplier Address"
                                                    class="form-control @error('address') is-invalid @enderror">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <input type="text" id="exampleInputDate"
                                                    wire:model.defer="inputs.phone"
                                                    placeholder="Enter Supplier Phone Number"
                                                    class="form-control @error('phone') is-invalid @enderror">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12"><input type="text" id="exampleInputFirstName"
                                                    wire:model.defer="inputs.shopName"
                                                    placeholder="Enter Supplier Shop Name [LEAVE BLANK IF NONE]"
                                                    class="form-control @error('shopName') is-invalid @enderror">
                                                @error('shopName')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <!---->
                                            </div>

                                            <!---->
                                        </div>
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
                                                            wire:model.defer="photo" type="file"
                                                            accept=".png,.jpeg,.jpg" id="customFile"
                                                            class="custom-file-input @error('photo')
                                                                    is-invalid

                                                                    @enderror">
                                                        @error('photo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror

                                                        <label for="customFile" class="custom-file-label">Supplier
                                                            Image</label>
                                                    </div>
                                                    <div x-show="isUploading_2"
                                                        class="progress progress-sm rounded  mt-2"
                                                        style="display: none;">
                                                        <div class="progress-bar bg-primary progress-bar-striped"
                                                            role="progressbar" x-bind:style="`width:${progress_2 }%`"
                                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                                            style="width:3%"></div>
                                                        <span class="sr-only">40% complete</span>
                                                    </div>
                                                    <div class="d-flex justify-content-around">

                                                        @if (!empty($photo) || !empty($inputs['photo']))
                                                            <ul>


                                                                <div style="position:relative;" class="mt-5 ml-3">
                                                                    @if (isset($photo) && is_object($photo))
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
                                                                                    src="{{ $photo->isPreviewable() ? $photo->temporaryUrl() : '/storage/err.png' }}"
                                                                                    width=250 height=230>
                                                                            </div>
                                                                        </li>
                                                                    @elseif(!empty($inputs['photo']))
                                                                        <li>
                                                                            <div
                                                                                class="item d-flex align-items-center justify-content-center">
                                                                                <img class="rounded" width=250
                                                                                    height=250
                                                                                    src="{{ '/storage/' . $supplier_img_path . '/' . $inputs['photo'] }}">
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

                                    <div class="form-group"><button type="submit"
                                            class="btn btn-primary btn-block">{{ $btn_text }}</button>
                                    </div>
                                    </form>
                                    <div class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
