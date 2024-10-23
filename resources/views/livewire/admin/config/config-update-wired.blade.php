<div class="main-panel">
    <x-spinner/>
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

        <div class="row d-flex justify-content-center align-items-center">

            <div class=" col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif


                        <h4 class="card-title">{{$admin_details['name']}}, You can update your details here</h4>
                        @if(Session::has('error_msg'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{Session::get('error_msg')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(Session::has('success_msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{Session::get('success_msg')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <p class="card-description">
                            Is that simple :)
                        </p>
                        <form method="POST" enctype="multipart/form-data" class="forms-sample"

                            wire:submit.prevent="updateConfig">



                            <div class="form-group">
                                <input wire:model.defer='inputs.shop_name' type="text" class="form-control form-control-lg
                                @error('shop_name')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Shop Name">

                                @error('shop_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>
                              <div class="form-group">
                                <input wire:model.defer='inputs.shop_number' type="text" class="form-control form-control-lg
                                @error('shop_number')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Official Phone Number">

                                @error('shop_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>
                              <div class="form-group">
                                <input wire:model.defer='inputs.shop_address' type="text" class="form-control form-control-lg
                                @error('shop_address')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Business Address">

                                @error('shop_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>
                              <div class="form-group">
                                <input wire:model.defer='inputs.shop_location' type="text" class="form-control form-control-lg
                                @error('shop_location')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Business Location">

                                @error('shop_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>
                              <div class="form-group">
                                <input wire:model.defer='inputs.shop_email' type="email" class="form-control form-control-lg
                                @error('shop_email')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Business E-mail">

                                @error('shop_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>
                              <div class="form-group">
                                <input wire:model.defer='inputs.shop_tin_number'
                                '+ type="text" class="form-control form-control-lg
                                @error('shop_tin_number')
                                  is-invalid
                                @enderror
                                " id="exampleInputUsername1" placeholder="Business TIN Number">

                                @error('shop_tin_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                              </div>

                                <div class="form-group" x-data="{ isUploading_2: false, progress_2: 3 }"
                                x-on:livewire-upload-start="isUploading_2 = true"
                                x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                                x-on:livewire-upload-error="isUploading_2 = false"
                                x-on:livewire-upload-progress="progress_2 = $event.detail.progress">
                                <div class="custom-file" style="margin-top: 16px;"><input
                                    multiple
                                        wire:model.defer="image" type="file"
                                        accept=".png,.jpeg,.jpg" id="img_file"
                                        class="custom-file-input @error('image')
                                                is-invalid

                                                @enderror">
                                                @error('image.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror


                                    <label for="customFile" class="custom-file-label">Shop
                                        Image [CAN BE EMPTY] </label>
                                </div>
                                <div x-show="isUploading_2"
                                    class="progress progress-sm rounded  mt-2"
                                    style="display: none;">
                                    <div class="progress-bar bg-primary progress-bar-striped"
                                        role="progressbar" x-bind:style="`width:${progress_2 }%`"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                        style="width:3%"></div>
                                    <span class="sr-only" >40% complete</span>
                                </div>
                                <div class="d-flex justify-content-around">

                                    @if (!empty($image) || !empty($configLogo))
                                        <ul>


                                            <div style="position:relative;" class="mt-5 ml-3">
                                                @if (isset($image) && is_array($image))


                                                   @foreach ($image as $image )
                                                   <li class="mt-3 ">
                                                    <div
                                                        class="item d-flex align-items-center justify-content-center">

                                                        <img class="rounded"
                                                            src="{{ $image->isPreviewable() ? $image->temporaryUrl() : '/storage/err.png' }}"
                                                            width=250 height=230>
                                                    </div>
                                                </li>
                                                   @endforeach
                                                @elseif(isset($configLogo))

                                                   @foreach ($configLogo as $config_img )
                                                   <li class="mt-2">
                                                    <div
                                                        class="item d-flex align-items-center justify-content-center">
                                                        <img class="rounded" width=250
                                                            height=250
                                                            src="{{ '/storage/' . $shop_img_path . '/' . $config_img['media_name'] }}">
                                                    </div>

                                                </li>
                                                   @endforeach
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







                            </div>








                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>
