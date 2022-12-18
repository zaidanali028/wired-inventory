
<div class="main-panel">
    <x-spinner/>

        <div class="content-wrapper">
            @include('admin.layout.auth_welcome')


            <div class="row">

                <div class="col-md-12 grid-margin stretch-card">

                    <div class="card-body">





                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">BRANDS MANAGEMENT</h4>
                                <div class="row w-100">
                                    <div class="d-flex justify-content-start w-50">
                                        <button wire:click.prevent="newbrand" class="btn btn-primary"><i class="mdi mdi-folder-plus"></i> Add New Brand </button>
                                    </div>
                                    <div class="d-flex justify-content-end w-50">
                                        <button wire:click.prevent="deleteAllbrands" class="btn btn-danger"><i class="mdi mdi-delete-sweep"></i> Clear All brands </button>
                                    </div>
                                </div>
                                <p class="card-description">

                                </p>
                                <div class="table-responsive">
                                    <table id='' class="dataTable table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    ID #
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                                <th>Actions</th>


                                            </tr>
                                        </thead>
                                        <tbody>



                                            @foreach ($brands as $brand)
                                                <tr>
                                                    <td>{{ $brand['id'] }}</td>
                                                    <td>{{ $brand['name'] }}</td>
                                                    <td>
                                                        @php
                                                            $icon = $brand['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';
                                                        @endphp
                                                        <span style="font-size: 20px"
                                                            class="mdi   {{ $icon }}">{{ $brand['status'] == 1 ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status_toggle_icon = $brand['status'] == 1 ? 'mdi-toggle-switch text-primary' : 'mdi-toggle-switch-off';
                                                        @endphp
                                                        <i wire:click="changebrandStatus({{ $brand['id'] }},{{ $brand['status'] }})" style="font-size: 30px"
                                                            class="mdi {{ $status_toggle_icon }}"></i>

                                                    </td>

                                                    <td>
    <a wire:click.prevent="editBrand({{ $brand['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>


                                                    <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deletebrandConfirm({{ $brand['id'] }})"></a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <button class="btn btn-outline-primary" onclick="makeSearchable()">Search Brands</button>

                                           <div class="mt-3 d-flex justify-content-end">
                                            {{ $brands->links() }}
                                           </div>


                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            @include('admin.layout.footer')


            <!-- partial -->
        </div>
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="add-brand-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="add-brand-modal">BRAND MANAGEMENT
                          </h5>
                        <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></i>
                        {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  --}}
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">   {{ $addNewbrand ? 'Add New brand' : 'Edit brand' }}</h4>
                                <p class="card-description">

                                </p>
                                <form class="forms-sample"
                                    wire:submit.prevent={{ $addNewbrand ? 'submitAddNewbrand' : 'updatebrand ' }}>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Name</label>
                                        <input value="" wire:model.defer="inputs.name" type="text"
                                            class="form-control @error('name') is-invalid @enderror


                                            id="exampleInputName1" placeholder="GUCCI & GABANA">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Status</label>

                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio"  name="rad" class="form-check-input"

                                                        wire:model.defer="inputs.status" value="1"
                                                        id="membershipRadios1" value="" checked="">
                                                    Active
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" name="rad" class="form-check-input" name="stat"
                                                        wire:model.defer="inputs.status" id="membershipRadios2"
                                                        value="0">
                                                    Inactive
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        @error('status')
                                        <labe class="text-danger fw-bold ml-3" style="font-size:80%">{{ $message }}</label>
                                    @enderror
                                    </div>

                                    </div>




                                    {{--  status err not showing  --}}


                                    <button type="submit" class="btn btn-primary mr-2">{{ $btn_text }}</button>
                                   @if($addNewbrand==true)
                                   <button wire:click="onCancel" class="btn btn-light">Cancel</button>
                                   @else
                                   <button type="reset" class="btn btn-light">Cancel</button>


                                   @endif

                                </form>
                            </div>
                        </div>
                    </div>
                    {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>  --}}
                </div>
            </div>
        </div>
    </div>


