{{--  its view  --}}
{{--  @extends('admin.layout.layout')  --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($shop_details['shop_name'])?$shop_details['shop_name']:'SystemsMadeByZaid'}} | {{ Session::get('page') }}</title>

    <!-- plugins:css -->
    {{--  jquery css start  --}}
    <link rel="stylesheet" href="{{url('admin/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/bootstap4.min.css')}}">

    {{--  jquery css end  --}}
    <link rel="stylesheet" href="{{url('admin/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/mdi/css/materialdesignicons.min.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('admin/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{url('admin/css/vertical-layout-light/style.css')}}">
    <!-- inject:toastr css -->
    <link rel="stylesheet" href="{{url('admin/css/toastr.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/load-awesome.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('admin/images/favicon.png')}}" />
    <livewire:styles />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>
<body >
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
    <livewire:admin.settings.forgot-pass-wired/>

                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>









<!-- plugins:js -->
<script src="{{url('admin/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{url('admin/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{url('admin/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('admin/js/dataTables.select.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap.min.js')}}"></script>
<script src="{{url('admin/js/toastr.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{url('admin/js/custom.js')}}"></script>

<livewire:scripts />


</div>
</body>

</html>



