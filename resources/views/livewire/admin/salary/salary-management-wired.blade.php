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
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            {{--  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">employee List</h2> <a
                                    wire:click.prevent="newemployee" class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Add employee</a>
                            </div>  --}}
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Name #
                                            </th>
                                            <th>
                                                Picture #
                                            </th>
                                            <th>
                                                Phone
                                            </th>
                                            <th>
                                                employee
                                            </th>
                                            <th>
                                                Date Joined
                                            </th>
                                            <th>Action</th>



                                        </tr>
                                    </thead>
                                    <tbody>



                                        @forelse ($Employees_data as $employee)
                                            <tr>

                                                <td class="text-capitalize">{{ $employee['name'] }}</td>
                                                <td>
                                                    @if (!empty($employee['get_employee_admin_data']['photo']))
                                                        <img src="{{ asset('storage/' . $admin_img_path . '/' . $employee['get_employee_admin_data']['photo']) }}"
                                                            alt="image">
                                                    @elseif(empty($admin_by_type['photo']))
                                                        <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                                            alt="profile" />
                                                    @endif



                                                </td>
                                                <td class="text-capitalize">{{ $employee['mobile'] }}</td>
                                                <td class="text-capitalize">GH₵ {{ $employee['salary'] }}</td>
                                                <td class="text-capitalize">{{ $employee['joining_date'] }}</td>
                                                <td class="text-capitalize">
                                                    <button class="btn btn-sm rounded btn-outline-primary"
                                                    wire:click.prevent="newSalary({{ $employee['id'] }})"
                                                    >
                                                        Pay employee
                                                    </button>
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
                                    Employees_data</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $Employees_data->links() }}
                                </div>
                            </div>
                            <div class="card-footer"></div>
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
    <div wire:ignore.self class="modal  fade" id="add-salary-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-salary-modal">SALARY MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>

                </div>
                <div class="modal-body">
                    <div  class="login-form">
                        <div  class="text-center">
                            <h1  class="h4 text-gray-900 mb-4">Pay <strong>{{ !empty($inputs['employee_name'])?$inputs['employee_name'] :'' }}'s</strong> Salary</h1>
                        </div>
                        <form  wire:submit.prevent='process_salary'>
                            <div  class="form-group">
                                <div  class="form-row">
                                    <div  class="col-md-6"><label
                                            for="exampleFormControlSelect1">Name</label> <input
                                            wire:model.defer="inputs.employee_name"
                                            disabled="disabled" type="text" id="exampleInputFirstName"
                                            placeholder="Name" class="form-control"></div>
                                    <div  class="col-md-6"><label
                                            for="exampleFormControlSelect1">Email</label> <input
                                            wire:model.defer="inputs.employee_email"
                                            disabled="disabled" type="email" id="exampleInputEmail"
                                            placeholder="Email" class="form-control"></div>
                                </div>
                            </div>
                            <div  class="form-group">
                                @php
                                $monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                                $currentMonthNum = date("m");
                                $currentMonthName = $monthNames[$currentMonthNum - 1];


                                            @endphp
                                <div  class="form-row">
                                    <div  class="col-md-6"><label
                                            for="exampleFormControlSelect1">
                                            Employee
                                            Salary
                                        </label> <input
                                            disabled="disabled" type="number" id="exampleInputemployee"
                                            wire:model.defer="inputs.employee_salary"
                                            placeholder="Enter employee" class="form-control">
                                        <!---->
                                    </div>
                                    <div  class="col-md-6"><label
                                            for="exampleFormControlSelect1">Select Month</label>
                                            <select wire:model.defer="inputs.salary_month"
                                             id="exampleFormControlSelect1" class="form-control @error('salary_month')
                                             bg-danger is-invalid

                                             @enderror">
                                            <option  value="" >* Select Month </option>
                                            @foreach ($months as $month)


                                             @if( $currentMonthName==$month)

                                            <option  value="{{ $month }}" selected >{{ $month }}</option>
                                            @else
                                            <option value="{{ $month }}">{{ $month }}</option>

                                            @endif


                                            @endforeach
                                        </select>
                                        @error('salary_month')
                                                <div class="fw-bold text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div  class="form-group"><button  type="submit"
                                    class="btn btn-primary btn-block">Pay Now</button></div>
                        </form>
                        <div  class="text-center"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
