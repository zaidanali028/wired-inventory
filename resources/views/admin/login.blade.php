<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($shop_details['shop_name'])?$shop_details['shop_name']:'SystemsMadeByZaid'}} | {{ Session::get('page') }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{url('admin/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{url('admin/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('admin/images/logo-mini.svg')}}" />

</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            @php
                                $logo_path=!empty($big_logo)?'/storage/config/'.$big_logo['media_name']:'admin/images/logo.svg';

                                @endphp
                                {{--  {{$logo_path}}  --}}
                            <img src="{{asset($logo_path)}}" width='150' height='36.98' alt="logo">
                        </div>
                        <h4>Hello! let's get started</h4>

                        @if(Session::has('error_msg'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{Session::get('error_msg')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif

                            <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" action="{{url('/admin/login')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                {{-- <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Keep me signed in
                                    </label>
                                </div> --}}
                                <a href="/pos" target="_blank" class="auth-link text-black">Access POS[WITHOUT LOGIN]</a>

                                <a href="/admin/forgot" class="auth-link text-black">Forgot password?</a>
                            </div>
                            {{--  <div class="mb-2">
                                <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                    <i class="ti-facebook mr-2"></i>Connect using facebook
                                </button>
                            </div>  --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{url('admin/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{url('admin/js/off-canvas.js')}}"></script>
<script src="{{url('admin/js/hoverable-collapse.js')}}"></script>
<script src="{{url('admin/js/template.js')}}"></script>
<script src="{{url('admin/js/settings.js')}}"></script>
<script src="{{url('admin/js/todolist.js')}}'"></script>
<!-- endinject -->
</body>

</html>
