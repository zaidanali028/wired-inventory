<div class="auth-form-light text-left py-5 px-4 px-sm-5">
    <x-spinner/>

    <div class="brand-logo">
        @php
            $logo_path=!empty($small_logo)?'/storage/config/'.$small_logo['media_name']:'admin/images/logo.svg';

            @endphp
            {{--  {{$logo_path}}  --}}
        <img src="{{asset($logo_path)}}" width='150' height='36.98' alt="logo">
    </div>
    <h4 class='text-capitalize'>Hello! enter your [{{!empty($shop_details['shop_name']) ?$shop_details['shop_name']:'' }}'s email] to get back in control</h4>

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
    <form class="pt-3" wire:submit.prevent='submitForgotPass' method="post">
        @csrf
        <div class="form-group">
            <input type="email" id="email" wire:model.defer="inputs.email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >REQUEST PASS</button>
        </div>


    </form>
</div>
