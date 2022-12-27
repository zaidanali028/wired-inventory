<div class="main-panel">
    <x-spinner />

    <div class="c
        fontent-wrapper">
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





        <div class="row">


            <div  class=" col-xl-12 col-lg-12 col-md-12">
                <div  class="row">
                    <div  class="col-lg-12 mb-4">
                        <div  class="card">
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2  class="m-0 font-weight-bold text-primary">Categorie(s) List</h2> <a  wire:click.prevent='newCategory'
                                    class="btn btn-primary float-right" style="margin-top: 6px; margin-right: 6px;">Add New Category</a>
                            </div>

                                @if ($current_category_count >= 1)
                                @if (is_array($main_categories) || is_object($main_categories))

                                    <div class=" table-responsive">
                                        <table id='' class="dataTable table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        ID #
                                                    </th>
                                                    <th>
                                                        Main Category's Name
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



                                                @forelse ($main_categories as $category)
                                                    <tr>
                                                        <td>{{ $category['id'] }}</td>
                                                        <td>{{ $category['category_name'] }}</td>

                                                        <td>
                                                            @php
                                                                $icon = $category['status'] == 1 ? 'mdi-checkbox-multiple-blank-circle text-success' : 'mdi-checkbox-multiple-blank-circle-outline text-dark';
                                                            @endphp
                                                            <span style="font-size: 20px"
                                                                class="mdi   {{ $icon }}">{{ $category['status'] == 1 ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $status_toggle_icon = $category['status'] == 1 ? 'mdi-toggle-switch text-primary' : 'mdi-toggle-switch-off';
                                                            @endphp
                                                            <i wire:click="changeMainCategoryStatus({{ $category['id'] }},{{ $category['status'] }})"
                                                                style="font-size: 30px"
                                                                class="mdi {{ $status_toggle_icon }}"></i>

                                                        </td>

                                                        <td>
                                                            <a wire:click.prevent="editMainCategory({{ $category['id'] }})"
                                                                style="font-size: 20px"
                                                                class=" mdi mdi-pencil-box-outline"></a>


                                                            <a  style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                                wire:click.prevent="deleteMainCategoryConfirm({{ $category['id'] }})"></a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>
                                                @endforelse



                                            </tbody>
                                        </table>
                                        <button class="ml-2  btn btn-outline-primary" onclick="makeSearchable()">Search Categories</button>

                                        <div class="mt-3 d-flex justify-content-end">
                                            {{ $main_categories->links() }}
                                        </div>


                                    </div>
                                @endif
                            @else
                                <p class="text-center display-2">Please Add Main Categories </p>
                            @endif

                            <div  class="card-footer"></div>
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
    <div wire:ignore.self class="modal fade" id="add-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-category-modal">
                        CATEGORY MANAGEMENT</h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>
                    {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  --}}
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> <i class="mdi mdi-folder-plus"></i>
                                {{ $addNewCategory ? 'Add New Main Category' : 'Edit Main Category' }} </h4>
                            <p class="card-description">

                            </p>
                            <form class="forms-sample"
                                wire:submit.prevent={{ $addNewCategory ? 'submitAddNewMainCategory' : 'updateMainCategory ' }}>
                                <div class="form-group">
                                    <label for="exampleInputName1">Main Category's Name</label>
                                    <input wire:model.defer="inputs.category_name" type="text"
                                        class="form-control @error('category_name') is-invalid @enderror


                                            id="exampleInputName1"
                                        placeholder="MEN">
                                    @error('category_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status</label>

                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="stat" class="form-check-input"
                                                    wire:model.defer="inputs.status" value="1"
                                                    id="membershipRadios1" value="" checked="">
                                                Active
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="stat"
                                                    wire:model.defer="inputs.status" id="membershipRadios2"
                                                    value="0">
                                                Inactive
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @error('status')
                                            <labe class="text-danger fw-bold ml-3" style="font-size:80%">
                                                {{ $message }}</label>
                                            @enderror
                                    </div>

                                </div>




                                {{--  status err not showing  --}}


                                <button type="submit" class="btn btn-primary mr-2">{{ $btn_text }}</button>
                                @if($addNewCategory==true)
                                <button wire:click="onCancel" class="btn btn-light">Cancel</button>
                                @else
                                <button type="reset" class="btn btn-light">Cancel</button>



                                @endif

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
