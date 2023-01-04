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

                            wire:submit.prevent="update_details">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Type</label>
                                <input type="text" value="{{ $admin_details['type']}}" readonly  class="form-control text-uppercase" id="exampleInputEmail1" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">E-mail</label>
                                <input
                                class="form-control @error('email') is-invalid @enderror

                                type="text"  wire:model.defer='inputs.email' readonly class="form-control" id="exampleInputUsername1" placeholder="email">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Username</label>
                                <input
                                class="form-control @error('name') is-invalid @enderror"

                                wire:model.defer="inputs.name"   id="current_password" type="text" class="form-control" id="exampleInputPassword1" placeholder="Your Official Name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Phone</label>
                                <input
                                class="form-control @error('mobile') is-invalid @enderror"

                                wire:model.defer="inputs.mobile"   id="new_password" type="text" class="form-control" id="exampleInputPassword1" placeholder="+233----">
                                @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputName1">Your Display Picture </label>



                                <div x-data="{ isUploading_2: false, progress_2: 3 }" x-on:livewire-upload-start="isUploading_2 = true"
                                x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                                x-on:livewire-upload-error="isUploading_2 = false"
                                x-on:livewire-upload-progress="progress_2 = $event.detail.progress">
                                <input type="file" multiple id="img_file" accept=".png,.jpeg,.jpg"
                                    class="form-control  @error('image') is-invalid @enderror  @error('image') is-invalid @enderror"
                                    wire:model.defer="image">
                                <div x-show="isUploading_2" class="progress progress-sm rounded  mt-2">
                                    <div class="progress-bar bg-primary progress-bar-striped"
                                        role="progressbar" x-bind:style="`width:${progress_2 }%`"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    <span class="sr-only">40% complete</span>
                                </div>

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror


                                <div class="d-flex justify-content-around">
                                    @if (!empty($image) ||!empty($admin_details['image']))
                                    <ul>


                                            <div style="position:relative;" class="mt-5 ml-3">
                                                @if (isset($image) && is_object($image[0]))
                                                    {{--  if object-then user is trying to upload new file  --}}

                                                    <button class="close"
                                                        style=" right:50px;
                                position: absolute; ">
                                                        <span class="text-dark display-2"
                                                            wire:click="removeImg()">&times;</span>
                                                    </button>

                                                    <li>
                                                        <div class="item d-flex align-items-center justify-content-center">

                                                    <img class="rounded"
                                                        src="{{ $image[0]->isPreviewable() ? $image[0]->temporaryUrl() : '/storage/err.png' }}"
                                                        width=250 height=230>
                                                        </div>
                                                    </li>


                                                @endif

                                            </div>
                                            @elseif(!empty($inputs['photo']))
                                                {{--  else get old one from the db  --}}


                                                <li>
                                                    <div class="item d-flex align-items-center justify-content-center">
                                                        <img class="rounded"
                                                        width=250 height=250

                                                        src="{{ '/storage/admin_imgs/' . $inputs['photo'] }}"

                                                            >
                                                    </div>

                                        </li>
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
