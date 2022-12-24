<div class="main-panel">
    <x-spinner />

    <div class="c
        fontent-wrapper">
        @include('admin.layout.auth_welcome')


        <div class="row">
            <div  class="col-xl-12 col-lg-12 col-md-12">
                <div  class="row">
                    <div  class="col-lg-12 mb-4">
                        <div  class="card">
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2  class="m-0 font-weight-bold text-primary">Employee List</h2> <a
                                wire:click.prevent="newEmployee"
                                    class="btn btn-primary float-right" style="margin-top: 6px; margin-right: 6px;">Add New Employee</a>
                            </div>
                            <div  class="table-responsive">
                                <table id='' class="dataTable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Name #
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Mobile
                                            </th>
                                            <th>
                                                Date Joined
                                            </th>
                                            <th>Salary</th>
                                            <th>Actions</th>


                                        </tr>
                                    </thead>
                                    <tbody>



                                        @forelse ($employees as $employee)
                                            <tr>

                                                <td class="text-capitalize">{{ $employee['name'] }}</td>
                                                <td class="text-capitalize">{{ $employee['email'] }}</td>
                                                <td class="text-capitalize">{{ $employee['mobile'] }}</td>
                                                <td class="text-capitalize">{{ $employee['joining_date'] }}</td>
                                                <td class="text-capitalize">{{ $employee['salary'] }}</td>
                                    <td>
                                                    <a wire:click.prevent="editEmployee({{ $employee['id'] }})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>


                                                    <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deleteEmployeeConfirm({{ $employee['id'] }})"></a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                                <button class="ml-2   btn btn-outline-primary" onclick="makeSearchable()">Search
                                    Employees</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $employees->links() }}
                                </div>
                            </div>
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
    <div wire:ignore.self class="modal  fade" id="add-employee-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-employee-modal">Employee MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>

                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body p-0">
                            <h4 class="card-title"> {{ $addNewEmployee ? 'Add New Employee' : 'Edit Employee' }}</h4>

                            <div class="row">
                                <div class="col-md-10">

                                    <div class="login-form">
                                        <div class="text-center">

                                        </div>
                                        <form enctype="multipart/form-data"
                                            wire:submit.prevent={{ $addNewEmployee ? 'submitaddNewEmployee' : 'updateEmployee ' }}>
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @forelse ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @empty
                                                        <tr>
                                                            <td colspan="2"> No Data To Show!</td>
                                                        </tr>
                                                        @endforelse

                                                </ul>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="">Employee ID</label>
                                                    <select wire:change.prevent= "$emit('getEmp', $event.target.value)"
                                                    class="form-control @error('id') bg-danger is-invalid @enderror"

                                                        wire:model.defer="inputs.id">
                                                        <optgroup label="SELECT AN EMPLOYEE" ></optgroup>
                                                        @forelse ($employees_data as $employee_data)
                                                         @if(!empty($this->inputs) &&  $this->inputs['id']==$employee_data['id'])>
                                                           <option value="{{ $employee_data['id'] }}" selected> {{ $employee_data['name'] }}</option>
                                                           @else
                                                           <option value="{{ $employee_data['id'] }}"> {{ $employee_data['name'] }}</option>
                                                           @endif
                                                           @empty
                                            <tr>
                                                <td colspan="2"> No Data To Show!</td>
                                            </tr>

                                                            @endforelse
                                                    </select>
                                                    @error('id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>


                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6"><input type="text"
                                                            id="exampleInputFirstName" wire:model.defer="inputs.name"
                                                            placeholder="Enter Your Full Name"
                                                            class="form-control @error('name') is-invalid @enderror">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror

                                                        <!---->
                                                    </div>
                                                    <div class="col-md-6"><input type="email" id="exampleInputEmail"
                                                            wire:model.defer="inputs.email" placeholder="Enter Email"
                                                            class="form-control @error('email') is-invalid @enderror">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6"><input type="text" id="exampleInputmobile"
                                                            wire:model.defer="inputs.mobile"
                                                            placeholder="Enter mobile Number"
                                                            class="form-control @error('mobile') is-invalid @enderror">
                                                        @error('mobile')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <!---->
                                                    </div>
                                                    <div class="col-md-6"><input type="number" id="exampleInputSalary"
                                                            wire:model.defer="inputs.salary" placeholder="Enter Salary"
                                                            class="form-control @error('salary') is-invalid @enderror">
                                                        @error('salary')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <input type="text" wire:model.defer="inputs.address"
                                                            id="exampleInputAddress" placeholder="Enter Full Address"
                                                            class="form-control @error('address') is-invalid @enderror">


                                                        @error('address')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror

                                                    </div>
                                                    <div class="col-md-6"><input type="text" id="exampleInputNid"
                                                            wire:model.defer="inputs.national_id"
                                                            placeholder="Ghana Card(GHA-3433-4543)"
                                                            class="form-control @error('national_id') is-invalid @enderror"
                                                            >
                                                        @error('national_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <!---->
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <label for="">Date Of Registeration</label>

                                                <div class="form-row">


                                                    <div class="col-md-6"><input type="date" id="exampleInputDate"
                                                            wire:model.defer="inputs.joining_date"
                                                            placeholder="Enter Joining Date"
                                                            class="form-control @error('joining_date') is-invalid @enderror">
                                                        @error('joining_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <!---->
                                                        <div x-data="{ isUploading_2: false, progress_2: 3 }"
                                                            x-on:livewire-upload-start="isUploading_2 = true"
                                                            x-on:livewire-upload-finish="isUploading_2 = false; progress=3"
                                                            x-on:livewire-upload-error="isUploading_2 = false"
                                                            x-on:livewire-upload-progress="progress_2 = $event.detail.progress">

                                                            <div x-show="isUploading_2"
                                                                class="progress progress-sm rounded  mt-2">
                                                                <div class="progress-bar bg-primary progress-bar-striped"
                                                                    role="progressbar"
                                                                    x-bind:style="`width:${progress_2 }%`"
                                                                    aria-valuenow="70" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                                <span class="sr-only">40% complete</span>
                                                            </div>





                                                            <div class="d-flex justify-content-around">

                                                                @if (!empty($inputs['photo']))
                                                                <ul>


                                                                    <div style="position:relative;"
                                                                        class="mt-5 ml-3">







                                                                            <li>
                                                                                <div
                                                                                    class="item d-flex align-items-center justify-content-center">
                                                                                    <img class="rounded" width=250
                                                                                        height=250

                                                                                        src="{{ '/storage/'.$admin_img_path.'/' . $inputs['photo'] }}">

                                                                                </div>

                                                                            </li>

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
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary mr-2">{{ $btn_text }}</button>

                                            </div>
                                        </form>
                                        <div class="text-center"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
