<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/"><img src="{{asset('admin/images/logo.svg')}}" class="mr-2" alt="logo"/></a>


@php
$small_logo_path=!empty($small_logo)?'/storage/config/'.$small_logo['media_name']:'admin/images/logo.svg';

@endphp
        <a class="navbar-brand brand-logo-mini" href="/"><img src="{{$small_logo_path}}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  {{--  <i class="icon-search"></i>  --}}
                </span>
                    </div>
                    {{--  <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">  --}}
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="mdi  mdi-star-outline  mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Welcome And Thank You For Choosing <strong>#SystemsMadeByZaid</strong></h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                Adventure Is What We Love!
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="mdi mdi-meteor mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Always Remember!</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                               Navigate Easily Anywhere Within Ur Orders When
                               U Hit On (admin/orders). Click On The Calendar Icon
                               Under This Notification And Have Full Control!
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="mdi mdi-chart-bubble mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Truth Be Told</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                Becareful When Changing Your Credentials As Loosing It May Pose Greater Danger
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                  @if(empty($admin_details['photo']))
                  <img src="{{asset('admin/images/faces/face20.jpg')}}" alt="profile"/>



                    @elseif(!empty($admin_details['photo']))
                    @php
                        $admin_img=$admin_details['photo'];
                    @endphp
                    <img src="{{asset('storage/admin_imgs/'.$admin_img)}}" alt="profile"/>


                      @endif
                      {{--  @json($admin_details)  --}}


                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{url('/admin/update-details')}}">
                        <i class="mdi mdi-meteor text-primary"></i>
                        Update Details
                    </a>
                    <a class="dropdown-item" href="{{url('/admin/logout')}}">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
