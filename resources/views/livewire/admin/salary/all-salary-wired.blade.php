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
            <div class="col-xl-12 col-lg-12 col-md-12 mt-3">
                <strong class="mb-3"> MANAGE ALL SALARIES </strong>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @forelse ($salary_by_mnths as $salary_by_mnth=>$month_data )
                        <li class="nav-item " wire:ignore >
                            <a  class="nav-link  @if ($loop->first)
                                active

                            @endif"" data-toggle="tab" href="#{{ $salary_by_mnth }} " role="tab">{{ $salary_by_mnth }}</a>
                          </li>

                        @empty
                          <li>No Data To Show!</li>
                        @endforelse


                    </ul>

                    <!-- Tab panes -->
                                            <div class="tab-content">
                                                @forelse ($salary_by_mnths as $salary_by_mnth=>$month_data )

                                                <div wire:ignore.self class="tab-pane
                                                @if ($loop->first)
                                                active

                                            @endif"" id="{{$salary_by_mnth }}" role="tabpanel">
                                            {{--  <button class="btn btn-outline-primary" onclick="makeSearchable()">Search
                                                Salary Data</button>  --}}
                                                 <div class='table-responsive'>
                                                    <table id='' class="dataTable table table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th>Month</th>
                                                            <th>Employee Name </th>
                                                            <th>Amount</th>
                                                            <th>Salary Date</th>
                                                            <th>Action</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          @forelse ($month_data as $data )<tr>
                                                            {{--  @json($data)  --}}
                                                            <td>{{ $data->salary_month }}</td>
                                                            <td>{{ $data->get_emp['name'] }}</td>
                                                            <td>{{ $data->amount }}</td>
                                                            <td>{{ $data->salary_date }}</td>
                                                            <td>
                                                                <button class="btn btn-sm rounded btn-outline-primary"
                                                        wire:click.prevent="editSalary({{$data->id}})"
                                                        >
                                                            Edit Salary
                                                        </button>

                                                            </td>
                                                          </tr>

                                                          @empty
                                                            <td>No Data To Show!</td>


                                                          @endforelse

                                                        </tbody>


                                                      </table>

                                                </div>

                                                </div>
                                                @empty
                                                <div>No Data To Show!</div>
                                                @endforelse



                  </div>
            </div>



        </div>

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layout.footer')

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
                        <form  wire:submit.prevent="update_salary">
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
                                            {{ $currentMonthName }}
                                <div  class="form-row">
                                    <div  class="col-md-6"><label
                                            for="exampleFormControlSelect1">employee</label> <input
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
    </div


    <!-- partial -->

</div>
