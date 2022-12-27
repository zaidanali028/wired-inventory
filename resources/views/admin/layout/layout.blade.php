<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
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
<body>



 {{--  spinner from load awesome  --}}



<div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
@include('admin.layout.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
            <div id="settings-trigger"><i class="ti-settings"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default"></div>
                </div>
            </div>
        </div>
       
        <!-- partial -->


        @yield('content')


        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{url('admin/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{url('admin/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{url('admin/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('admin/js/dataTables.select.min.js')}}"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{url('admin/js/off-canvas.js')}}"></script>
<script src="{{url('admin/js/hoverable-collapse.js')}}"></script>
<script src="{{url('admin/js/template.js')}}"></script>
<script src="{{url('admin/js/settings.js')}}"></script>
<script src="{{url('admin/js/todolist.js')}}"></script>
<!-- endinject -->
<!--  livewire script  -->
<livewire:scripts />

<!-- Custom js for this page-->
<script src="{{url('admin/js/dashboard.js')}}"></script>
<script src="{{url('admin/js/Chart.roundedBarCharts.js')}}"></script>
<script src="{{url('admin/js/custom.js')}}"></script>
<!-- End custom js for this page-->
{{--  sweet alert plugin  --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--  sweet alert js  --}}
{{--  <script src="admin/js/swal.js"></script>  --}}
{{--  alpinejs  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js" integrity="sha512-Atu8sttM7mNNMon28+GHxLdz4Xo2APm1WVHwiLW9gW4bmHpHc/E2IbXrj98SmefTmbqbUTOztKl5PDPiu0LD/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{--  SelectIZE  --}}


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{--  datatable  --}}
<script src="{{url('admin/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('admin/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap.min.js')}}"></script>
<script src="{{url('admin/js/toastr.min.js')}}"></script>


</div>
</body>

</html>

