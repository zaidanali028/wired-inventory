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


            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">Admin(s) List</h2>
                                 <a
                                    wire:click.prevent='newadmin' class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Add An Admin</a>
                            </div>
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">

                                    <thead>
                                        <tr>

                                            <th>
                                                Name #
                                            </th>
                                            <th>
                                                Type
                                            </th>
                                            <th>
                                                Mobile
                                            </th>
                                            <th>
                                                E-mail
                                            </th>
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($admins_by_type as $admin_by_type)
                                        {{--  @json($admin_details)  --}}
                                            @if ($admin_by_type['id'] == $admin_details['id'])
                                                @php
                                                    continue;
                                                @endphp
                                            @else
                                                <tr>

                                                    <td class="py-1">
                                                        {{ $admin_by_type['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $admin_by_type['type'] }}

                                                    </td>
                                                    <td>
                                                        {{ $admin_by_type['mobile'] }}

                                                    </td>
                                                    <td>
                                                        {{ $admin_by_type['email'] }}

                                                    </td>
                                                    <td>
                                                        @if (!empty($admin_by_type['photo']))
                                                            <img src="{{ asset('storage/'.$admin_img_path.'/' . $admin_by_type['photo']) }}"
                                                                alt="image">
                                                        @elseif(empty($admin_by_type['photo']))
                                                            <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                                                alt="profile" />
                                                        @endif



                                                    </td>
                                                    <td>
                                                        <a wire:click.prevent="editadmin({{ $admin_by_type['id'] }})"
                                                            style="font-size: 20px"
                                                            class=" mdi mdi-pencil-box-outline"></a>


                                                        <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                            wire:click.prevent="deleteadminConfirm({{ $admin_by_type['id'] }})"></a>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $icon = $admin_by_type['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';

                                                        @endphp
                                                        <span style="font-size: 20px"
                                                            class="admin_status_{{ $admin_by_type['id'] }} mdi   {{ $icon }}">{{ $admin_by_type['status'] == 1 ? 'Active' : 'Inactive' }}
                                                        </span>

                                                    </td>
                                                    @php
                                                        $status_toggle_icon = $admin_by_type['status'] == 1 ? 'mdi-toggle-switch text-primary' : 'mdi-toggle-switch-off';
                                                    @endphp
                                                    <td> <i wire:click='adminStatChanger({{ $admin_by_type['id'] }},{{ $admin_by_type['status'] }})'
                                                            style="font-size: 30px"
                                                            class="mdi {{ $status_toggle_icon }}"></i> </td>

                                                </tr>
                                            @endif
                                            @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>

                                        @endforelse

                                    </tbody>
                                </table>
                                <button class="ml-2 btn btn-outline-primary" onclick="makeSearchable()">Search
                                    admins</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $admins_by_type->links() }}
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
    <div wire:ignore.self class="modal fade" id="add-admin-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-employee-modal">ADMIN MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></i>

                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body p-0">
                            <h4 class="card-title"> Add New Admin</h4>

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="login-form">
                                        <div class="text-center">

                                        </div>
                                        <form enctype="multipart/form-data"
                                            wire:submit.prevent={{ $addNewadmin ? 'submitaddNewadmin' : 'updateadmin ' }}>


                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @forelse ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                            @empty
                                                            <tr>
                                                                <td colspan="2"> No Data To Show!</td>
                                                            </tr>
                                                            @endforelse

                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <label for="">Admin Type</label>
                                                        <select
                                                            wire:change.prevent="$emit('getEmp', $event.target.value)"
                                                            class="form-control @error('type') bg-danger is-invalid @enderror"
                                                            wire:model.defer="inputs.type">
                                                            <option value="">*SELECT ACCESS TYPE</option>
                                                            <option value="superadmin"> SUPER-ADMIN</option>

                                                            <option value="employee"> EMPLOYEE</option>


                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-12"><input type="email"
                                                            id="exampleInputEmail" wire:model.defer="inputs.email"
                                                            placeholder="Enter Email"
                                                            class="form-control @error('email') is-invalid @enderror">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col-md-12 mt-5 "><input type="text"
                                                                id="exampleInputFirstName"
                                                                wire:model.defer="inputs.name"
                                                                placeholder="Enter Your Full Name"
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
                                                    <div class="col-md-12">
                                                        <input type="password" id="exampleInputDate"
                                                            wire:model.defer="inputs.password"
                                                            placeholder="Enter Employee New Pass"
                                                            class="form-control @error('password') is-invalid @enderror">
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <input type="text" id="exampleInputDate"
                                                            wire:model.defer="inputs.mobile"
                                                            placeholder="Enter Employee Phone Number"
                                                            class="form-control @error('mobile') is-invalid @enderror">
                                                        @error('mobile')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
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

                                                                <label for="customFile"
                                                                    class="custom-file-label">Employee Image</label>
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

                                                                @if (!empty($photo) || !empty($inputs['photo']))
                                                                    <ul>


                                                                        <div style="position:relative;"
                                                                            class="mt-5 ml-3">
                                                                            @if (isset($photo) && is_object($photo))
                                                                                {{--  if object-then user is trying to upload new file  --}}

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
                                                                            @else
                                                                                {{--  else get old one from the db  --}}



                                                                                <li>
                                                                                    <div
                                                                                        class="item d-flex align-items-center justify-content-center">
                                                                                        <img class="rounded" width=250
                                                                                            height=250
                                                                                            src="{{ '/storage/' . $admin_img_path . '/' . $inputs['photo'] }}">
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
                                            <div class="form-group ">
                                                <label class="col-sm-3 col-form-label">Employee Status</label>

                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="rad2"
                                                                class="form-check-input"
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
                                                                <input type="radio" name="rad2"
                                                                    class="form-check-input"
                                                                    wire:model.defer="inputs.status"
                                                                    id="membershipRadios2" value="0">
                                                                Not Active
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
