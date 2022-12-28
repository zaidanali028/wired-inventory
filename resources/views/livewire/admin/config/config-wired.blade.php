
<div class="row w-100 mx-0">
    <x-spinner />

    <div class="col-lg-7 card mx-auto">
      <div class="auth-form-light text-left py-5 px-4 px-sm-5">
        <div class="brand-logo">
          <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
        </div>
        <h4>Welcome And Thank You For Reaching For The Best! <strong>#SystemsMadeByZaid</h4>
        <h6 class="font-weight-light">Taking control of your shop is easy. It only takes a few steps</h6>
        <form class="pt-3" wire:submit.prevent='submitConfig'>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>


                        @endforeach

                </ul>
            </div>
        @endif
            <div class="row">
          <div class="col-md-6">
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
              <div class="form-group">
                <div x-data="{ isUploading_2: false, progress_2: 3 }"
                x-on:livewire-upload-start="isUploading_2 = true"
                x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                x-on:livewire-upload-error="isUploading_2 = false"
                x-on:livewire-upload-progress="progress_2 = $event.detail.progress">
                <div class="custom-file" style="margin-top: 16px;"><input
                        wire:model.defer="image" type="file"
                        accept=".png,.jpeg,.jpg" id="customFile"
                        class="custom-file-input @error('image')
                                is-invalid

                                @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="customFile" class="custom-file-label">Product
                        Image [CAN BE EMPTY] </label>
                </div>
                <div x-show="isUploading_2"
                    class="progress progress-sm rounded  mt-2"
                    style="display: none;">
                    <div class="progress-bar bg-primary progress-bar-striped"
                        role="progressbar" x-bind:style="`width:${progress_2 }%`"
                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                        style="width:3%"></div>
                    <span class="sr-only">40% complete</span>
                </div>
                <div class="d-flex justify-content-around">

                    @if (!empty($image) || !empty($inputs['image']))
                        <ul>


                            <div style="position:relative;" class="mt-5 ml-3">
                                @if (isset($image) && is_object($image))
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
                                                src="{{ $image->isPreviewable() ? $image->temporaryUrl() : '/storage/err.png' }}"
                                                width=250 height=230>
                                        </div>
                                    </li>
                                @elseif(!empty($inputs['image']))
                                    <li>
                                        <div
                                            class="item d-flex align-items-center justify-content-center">
                                            <img class="rounded" width=250
                                                height=250
                                                src="{{ '/storage/' . $product_img_path . '/' . $inputs['image'] }}">
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







            </div>

              </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" wire:model.defer="inputs_2.name" class="form-control form-control-lg
              @error('name')
                is-invalid
              @enderror
              " id="exampleInputUsername1" placeholder="Username">

              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror

            </div>
            <div class="form-group">
                <input type="email" wire:model.defer="inputs_2.email" class="form-control form-control-lg
                @error('email')
                  is-invalid
                @enderror
                " id="exampleInputUsername1" placeholder="admin@example.com">

                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

              </div>

              <div class="form-group">
                <input type="text" wire:model.defer="inputs_2.mobile" class="form-control form-control-lg
                @error('mobile')
                  is-invalid
                @enderror
                " id="exampleInputUsername1" placeholder="Phone Number">

                @error('mobile')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

              </div>
              <div class="form-group">
                <input type="password" wire:model.defer="inputs_2.password" class="form-control form-control-lg
                @error('password')
                  is-invalid
                @enderror
                " id="exampleInputUsername1" placeholder="Secure Password">

                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

              </div>
              <div class="form-group">
                <input type="password" wire:model.defer="inputs_2.password_confirmation" class="form-control form-control-lg
                @error('password')
                  is-invalid
                @enderror
                " id="exampleInputUsername1" placeholder="Confirm Secure Password">



              </div>

          </div>
         </div>











          <div class="mb-4">
            <div class="form-check">
              <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input">
                I agree to all Terms &amp; Conditions
              <i class="input-helper"></i></label>
            </div>
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >SIGN UP</button>
          </div>
          <div class="text-center mt-4 font-weight-light">
            Already have an account? <a href="/admin/login" class="text-primary">Login</a>
          </div>
        </form>
      </div>
    </div>
    </div>

