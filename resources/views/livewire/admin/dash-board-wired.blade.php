<input type="hidden" id='monthlySaleRecords' name="" value="{{ implode(',', $monthly_sell_records) }}">
<input type="hidden" id='monthlyIncomeRecords' name="" value="{{ implode(',', $monthly_income_records) }}">


<div class="main-panel">
    <input id="lat" type="hidden" wire:model="lat" />
    <input id="long" type="hidden" wire:model="inputs.long" />
    <div class="content-wrapper">
        @include('admin.layout.auth_welcome')

        {{--  @json($admin_details)  --}}
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people ">
                        @php
                            $random_bg_obj = (object) $random_bg;
                            $random_bg_key = array_rand($this->random_bg);
                            $random_bg = $random_bg_obj->$random_bg_key;
                            $random_bg = StrVal($random_bg);
                            $random_path = 'admin/images/dashboard/' . $random_bg . '.svg';
                        @endphp
                        <img height="289" src="{{ asset($random_path) }}" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div>
                                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i><sup></sup></h2>
                                </div>
                                <div >
                                    <h4 class="location font-weight-normal">{{ $random_item }}</h4>
                                    <h6 class="font-weight-normal mt-3 ">{{ $random_key }} </h6><strong
                                        class="text-primary"> #SystemsMadeByZaid</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale  bg-dark">
                            <div class="card-body">
                                <p class="mb-4">Sales Today</p>
                                <p class="fs-30 mb-2">GH₵ {{ $today_sell }}</p>
                                <p>{{ $sell_pct_change }}% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Icome Today</p>
                                <p class="fs-30 mb-2">GH₵ {{ $today_income }}</p>
                                <p>{{ $income_pct_change }}% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Due Amount For Today</p>
                                <p class="fs-30 mb-2">GH₵ {{ $today_due }}</p>
                                <p>{{ $due_pct_change }}% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Number of Clients</p>
                                <p class="fs-30 mb-2">({{ $this_mnth_customers }}/{{ $last_mnth_customers }})<p>(This Month/Last Month)</p>{{ $total_customers }}</p>
                                {{--  <p{{ $customer_pct_change }} % (30 days)</p>  --}}
                                <p>{{ $customer_pct_change }}% (30 days)</p>

                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="row">
                <div class="col-md-12 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <p class="mb-4">Expense Amount For Today</p>
                            <p class="fs-30 mb-2">GH₵ {{ $today_expense }}</p>
                            <p>{{ $expense_pct_change }}% (30 days)</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Sales Report</p>
                            <a href="#" class="text-info">View all</a>
                        </div>
                        <p class="font-weight-500">A Barchart Presenting A Clear View Of Shop's Performance Based On The
                            Sum Of Money(In Cedis) That Has Been Accumulated By The Shop</p>
                        <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="sales-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Sales Report</p>
                            <a href="#" class="text-info">View all</a>
                        </div>
                        <p class="font-weight-500">A Top Notch BarChart Showing Total Sales And Income In Ghanaian Cedis
                            Acquired By The Shop</p>
                        <div id="sales-pie-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="sales-pie-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>







        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h2 class="m-0 font-weight-bold text-primary">Stocked Out Product List</h2> <a
                                href="/admin/products" class="btn btn-primary float-right"
                                style="margin-top: 6px; margin-right: 6px;">Manage Your Stocks Like A Genius!</a>
                        </div>
                        <div class="table-responsive">

                            <table id='' class="dataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            ID #
                                        </th>
                                        <th>
                                            Product Name
                                        </th>
                                        <th>
                                            Cateogory
                                        </th>
                                        <th>
                                            Supplier
                                        </th>

                                        <th>
                                            Selling Price
                                        </th>
                                        <th>
                                            Buying Price
                                        </th>
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Uploaded By
                                        </th>

                                        <th>Status</th>
                                        <th>
                                            Product Quantity
                                        </th>
                                        <th>
                                            Product Code
                                        </th>



                                    </tr>
                                </thead>
                                <tbody>



                                    @forelse ($stock_out_products as $product)
                                        <tr>
                                            <td>{{ $product['id'] }}</td>
                                            <td class="text-capitalize">{{ $product['product_name'] }}</td>
                                            <td class="text-capitalize">{{ $product['get_category']['category_name'] }}
                                            </td>
                                            <td class="text-capitalize">{{ !empty($product['get_supplier'])?$product['get_supplier']['name']:'No Supplier' }}</td>
                                            <td class="text-capitalize">{{ $product['selling_price'] }}</td>
                                            <td class="text-capitalize">{{ $product['buying_price'] }}</td>
                                            <td>
                                                @if (!empty($product['image']))
                                                    <img src="{{ asset('storage/' . $product_img_path . '/' . $product['image']) }}"
                                                        alt="image">
                                                @elseif(empty($product['image']))
                                                    <img src="{{ asset('/storage/default_product.jpg') }}"
                                                        alt="profile" />
                                                @endif



                                            </td>
                                            <td class="text-capitalize">{{ $product['uploaded_by'] }}</td>
                                            <td>
                                                <p class="badge badge-danger">
                                                    Out Of Stock!
                                                </p>
                                            </td>
                                            <td class="text-capitalize">{{ $product['product_quantity'] }}</td>
                                            <td class="text-capitalize">
                                                {{ !empty($product['product_code']) ? $product['product_code'] : 'Product Has No Code!' }}
                                            </td>



                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2"> No Data To Show!</td>
                                        </tr>
                                    @endforelse


                                </tbody>
                            </table>
                            <div class=" d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary" onclick="makeSearchable()">Search
                                        Stocked Out Products</button>


                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button wire:click.prevent="load_more" class="btn btn-outline-primary">
                                        Load Extra...
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->

</div>
