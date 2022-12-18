
    <div class="main-panel">
        <div class="content-wrapper">
            @include('admin.layout.auth_welcome')
    <x-spinner />


            <div class="row d-flex justify-content-center align-items-center">

                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">


                            <h4 class="card-title">{{$admin_details['name']}}, You can update your password here</h4>
                            @if(Session::has('error_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{Session::get('error_msg')}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <p class="card-description">
                                Is that simple :) {{Session::get('error_msg')}}
                            </p>
                            <form class="forms-sample" method="post" wire:submit.prevent="update_password">
                                {{--  <form class="forms-sample" method="post" action="{{url('admin/update-password')}}">  --}}

                                <div class="form-group">
                                    <label for="exampleInputUsername1">E-mail</label>
                                    <input type="text"  readonly class="form-control" id="exampleInputUsername1" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Account Type</label>
                                    <input type="text" value="{{ $admin_details['type']}}" readonly  class="text-uppercase form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Current Password</label>
                                    <input
                                    class="form-control @error('current_password') is-invalid @enderror"

                                    wire:model.defer="inputs.current_password" id="current_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Current Password">
                                    @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                <span id="checkPassWd"></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">New Password</label>
                                    <input
                                    class="form-control @error('new_password') is-invalid @enderror"

                                    wire:model.defer="inputs.new_password" id="new_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                                    @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input
                                    class="form-control @error('confirm_password') is-invalid @enderror"

                                    wire:model.defer="inputs.confirm_password" id="confirm_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
                                    @error('confirm_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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

