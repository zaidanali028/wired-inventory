<div class="main-panel">
    <x-spinner />

    <div class="c
        fontent-wrapper">
        @include('admin.layout.auth_welcome')


        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 mt-3">
                <strong class="mb-3"> MANAGE ALL SALARIES FROM JANUARY-DECEMBER</strong>
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
                                            <button class="btn btn-outline-primary" onclick="makeSearchable()">Search
                                                Salary Data</button>
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
                                                        <td>{{ $data->id }}</td>
                                                      </tr>

                                                      @empty
                                                        <td>No Data To Show!</td>


                                                      @endforelse

                                                    </tbody>


                                                  </table>

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


    <!-- partial -->

</div>
