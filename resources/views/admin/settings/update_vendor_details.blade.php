@extends('admin.layout.layout')
@section('content')
<!-- partial:partials/_sidebar.html -->
        @include('admin.layout.side_bar')
        <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            @include('admin.layout.auth_welcome')

            <div class="row">

                <div class="col-md-12 grid-margin stretch-card">
                    @if ($slug == 'personal')
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


                                <h4 class="card-title">{{ $admin_details['name'] }}, You can update your personal details
                                    here</h4>
                                @if (Session::has('error_msg'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('error_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('success_msg'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('success_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <p class="card-description">
                                    Is that simple :)
                                </p>
                                <form enctype="multipart/form-data" class="forms-sample" method="post"
                                    action="{{ url('admin/update-vendor-details/personal') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Your Personal Email</label>
                                        <input type="text" name='email' value="{{ $vendor_details['email'] }}"
                                            class="form-control" id="exampleInputUsername1" placeholder="email">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1"> Your Username</label>
                                        <input name="name" value="{{ $vendor_details['name'] }}" id="current_password"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="Current Password">

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Your Phone Number</label>
                                        <input name="mobile" value="{{ $vendor_details['mobile'] }}" id="new_password"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="+233....">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Your Address Address</label>
                                        <input name="address" value="{{ $vendor_details['address'] }}" type="text"
                                            class="form-control" id="exampleInputPassword1"
                                            placeholder="123 Example Road. Texas">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Your Digital Address(If Ghanaian)</label>
                                        <input name="digital_address" value="{{ $vendor_details['digital_address'] }}"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="AK-231-532">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">City You Currently Base-In</label>
                                        <input name="city" value="{{ $vendor_details['city'] }}" type="text"
                                            class="form-control" id="exampleInputPassword1" placeholder="ACCRA">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">State You Currently Base-In</label>
                                        <input name="state" value="{{ $vendor_details['state'] }}" type="text"
                                            class="form-control" id="exampleInputPassword1" placeholder="GREATER ACCRA">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The Country You Currently Base-In</label>
                                      <div class="form-group">
                                        <select class="form-control" id="country" name="country">
                                            @foreach ($all_countries as $country )
                                            @if ( $country['country_name']==$vendor_details['country'])
                                            <option selected value="{{  $country['country_name']  }}" class="text-capitalize"> {{ $country['country_name'] }}
                                                </option>
                                                @else
                                            <option value="{{ $country['country_name'] }}" class="text-capitalize">{{ $country['country_name'] }}</option>
                                                @endif
                                            @endforeach

                                          </select>
                                      </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Update Profile Image</label>
                                        <input name="profile_img" type="file" class="form-control"
                                            id="exampleInputPassword1">
                                        @if (!empty($admin_details['image']))
                                            <a class=" mt-2 btn btn-outline-primary" data-toggle="modal"
                                                data-target="#mymodal">Click To Preview[CURRENT PICTURE]</a>
                                        @endif
                                    </div>
                                    @if (!empty($admin_details['image']))
                                        <div class="modal fade" id="mymodal">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2 class="text-center">Your Profile Image</h2>
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <img class='col-md-12'
                                                                    src="{{ url('admin/images/dynamic_images/' . $admin_details['image']) }}"
                                                                    class="lb-image">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    @endif


                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @elseif($slug == 'business')
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


                                <h4 class="card-title">{{ $admin_details['name'] }}, You can update your personal details
                                    here</h4>
                                @if (Session::has('error_msg'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('error_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('success_msg'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('success_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <p class="card-description">
                                    Is that simple :)
                                </p>
                                <form enctype="multipart/form-data" class="forms-sample" method="post"
                                    action="{{ url('admin/update-vendor-details/business') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Your Shop's Address</label>
                                        <input type="text" name='shop_address'
                                            value="{{ $vendor_business_details['shop_address'] }}" class="form-control"
                                            id="exampleInputUsername1" placeholder="email">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Your Shop's Contact Number</label>
                                        <input type="text" name='shop_mobile'
                                            value="{{ $vendor_business_details['shop_mobile'] }}" class="form-control"
                                            id="exampleInputUsername1" placeholder="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"> Your Shop's Name</label>
                                        <input name="shop_name" value="{{ $vendor_business_details['shop_name'] }}"
                                            id="current_password" type="text" class="form-control"
                                            id="exampleInputPassword1" placeholder="Current Password">

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The City Your Shop Is Located In</label>
                                        <input name="shop_city" value="{{ $vendor_business_details['shop_city'] }}"
                                            id="new_password" type="text" class="form-control"
                                            id="exampleInputPassword1" placeholder="+233....">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The State Your Shop Is Located In</label>
                                        <input name="shop_state" value="{{ $vendor_business_details['shop_state'] }}"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="123 Example Road. Texas">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The Country You Currently Base-In</label>
                                      <div class="form-group">
                                        <select class="form-control" id="shop_country" name="shop_country">
                                            @foreach ($all_countries as $country )
                                            @if ( $country['country_name']==$vendor_business_details['shop_country'] )
                                            <option selected value="{{  $country['country_name']  }}" class="text-capitalize"> {{ $country['country_name'] }}
                                                </option>
                                                @else
                                            <option value="{{ $country['country_name'] }}" class="text-capitalize">{{ $country['country_name'] }}</option>
                                                @endif
                                            @endforeach

                                          </select>
                                      </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The Shop's E-mail Address</label>
                                        <input name="shop_email" value="{{ $vendor_business_details['shop_email'] }}"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="123 Example Road. Texas">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The Shop's License Number(Not Mandatory)</label>
                                        <input name="shop_license_number"
                                            value="{{ $vendor_business_details['shop_license_number'] }}" type="text"
                                            class="form-control" id="exampleInputPassword1"
                                            placeholder="123 Example Road. Texas">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">The Shop's Website(Not Mandatory)</label>
                                        <input name="shop_website" value="{{ $vendor_business_details['shop_website'] }}"
                                            type="text" class="form-control" id="exampleInputPassword1"
                                            placeholder="123 Example Road. Texas">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Proof Of Address</label>
                                        <select name='shop_address_proof' class="form-control">
                                            @foreach ($proof_of_addresses as $proof_of_address)
                                                @if ($vendor_business_details['shop_address_proof'] == $proof_of_address)
                                                    <option selected value="{{ $proof_of_address }}">
                                                        {{ $proof_of_address }}</option>
                                                @else
                                                    <option value="{{ $proof_of_address }}">{{ $proof_of_address }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Proof Of Address Image</label>

                                        <input name=" shop_address_proof_image" type="file" class="form-control"
                                            id="exampleInputPassword1" placeholder="123 Example Road. Texas">
                                        @if (!empty($vendor_business_details['shop_address_proof_image']))
                                            <a class=" mt-2 btn btn-outline-primary" data-toggle="modal"
                                                data-target="#mymodal">Click To Preview[CURRENT PICTURE]</a>
                                        @endif
                                    </div>
                                    @if (!empty($vendor_business_details['shop_address_proof_image']))
                                        <div class="modal fade" id="mymodal">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2 class="text-center">Your Proof Of Address Image</h2>
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <img class='col-md-12'
                                                                    src="{{ url('admin/images/vendor_address_proofs/' . $vendor_business_details['shop_address_proof_image']) }}"
                                                                    class="lb-image">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    @endif




                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @elseif($slug == 'bank')
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


                                <h4 class="card-title">{{ $admin_details['name'] }}, You can update your bank details here
                                </h4>
                                @if (Session::has('error_msg'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('error_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('success_msg'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('success_msg') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <p class="card-description">
                                    Is that simple :)
                                </p>
                                <form class="forms-sample" method="post"
                                    action="{{ url('admin/update-vendor-details/bank') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">The Name On Your Account</label>
                                        <input type="text" name='account_holder_name'
                                            value="{{ $vendor_bank_details['account_holder_name'] }}"
                                            class="form-control" id="exampleInputUsername1"
                                            placeholder="Mr. Example Something...">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">The Name Of The Bank Your Account Is Registered
                                            Under</label>
                                        <input type="text" name='bank_name'
                                            value="{{ $vendor_bank_details['bank_name'] }}" class="form-control"
                                            id="exampleInputUsername1" placeholder="Barclays Bank">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"> Your Account Number</label>
                                        <input type="text" value="{{ $vendor_bank_details['account_number'] }}"
                                            name="account_number" class="form-control"
                                            id="exampleInputPassword1" placeholder="312335625632">

                                    </div>







                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>

                    @endif
                </div>

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a
                        href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from
                    BootstrapDash. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i
                        class="ti-heart text-danger ml-1"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
@endsection
