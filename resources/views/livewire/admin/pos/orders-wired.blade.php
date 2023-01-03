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
                <li class="breadcrumb-item"><a>Home</a></li>
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
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">All Orders List</h2> <a
                                    wire:click.prevent="orders_today" class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Orders Today</a>
                            </div>
                            @if (!empty($orders))
                                <div class="table-responsive">
                                    <table id='' class="dataTable table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Customer #
                                                </th>
                                                <th>Quantity Of Items Orderd</th>
                                                <th>
                                                    Order Worth(IN GH₵)
                                                </th>
                                                <th>
                                                    Paid By
                                                </th>
                                                <th>
                                                    Order Date
                                                </th>
                                                <th>
                                                    Action(s)
                                                </th>




                                            </tr>
                                        </thead>
                                        <tbody>



                                            @foreach ($orders as $order)
                                                <tr>

                                                    <td class="text-capitalize">{{ $order['get_customer']['name'] }}
                                                    </td>
                                                    <td class="text-capitalize">{{ $order['qty'] }}</td>
                                                    <td class="text-capitalize">₵{{ $order['total'] }}</td>
                                                    <td class="text-capitalize">{{ $order['payBy'] }}</td>

                                                    <td>{{ $order['order_date'] }}</td>
                                                    <td>
                                                        <button
                                                            wire:click.prevent="show_view_order({{ $order['id'] }})"
                                                            class="btn btn-sm bg-primary text-white">View Order</button>

                                                    </td>

                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <button class="ml-2   btn btn-outline-primary" onclick="makeSearchable()">Search
                                        Orders</button>

                                    <div class="mt-3 d-flex justify-content-end">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            @else
                                <strong>
                                    No data For Your Query!

                                </strong>
                            @endif
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
    <div wire:ignore.self class="modal  fade" id="view-order-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="view-order-modal">ORDER(S) MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>

                </div>
                {{-- ............................. modal -body .........................  --}}



                {{--  My own start here  --}}
                <div class="modal-body">
                    <div id="divToPrint">


                        {{-- print styling   --}}
                        <style>
                            @media print {

                                .top-print,
                                .cpm-det,
                                ,
                                .dev,
                                table {
                                    font-size: 11px;
                                }

                                .company-name {
                                    font-size: 15px;
                                }

                                .rest {
                                    font-size: 12px;
                                }

                            }
                        </style>


                        <div style="display: inline" class="top-print">
                            <div class="">{{ date('d/m/y h:i:s') }}</div>
                            <div style="float: right">Receipt#: {{ !empty($orderRecord_) ? $orderRecord_['id'] : '' }}
                            </div>
                        </div><br>

                        <div style="text-align: center" class="company-name text-capitalize">
                            {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_name'] : '' }}</div>
                        <div style="text-align: center; font-size:11px" class="">
                            {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_location'] : '' }}</div>
                        <div style="text-align: center" class="cmp-det">
                            {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_number'] : '' }}</div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" style="width: 100%; font-size: 11px;">
                                <thead class="thead-light">
                                    <tr style="text-align: left;">
                                        <th style="width: 40%">Item</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 20%">Unit Price</th>
                                        <th style="width: 30%">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($orderRecord_))
                                        @foreach ($orderRecord_['get_order_detail'] as $orderRecord_item)
                                            <tr>
                                                {{--  @json($orderRecord_item['product_details']["product_name"])  --}}
                                                <td>{{ $orderRecord_item['product_details']['product_name'] }}</td>
                                                {{--  <td>{{ !empty($orderRecord_item['product_details']['product_code'])?$orderRecord_item['product_details']['product_code']:'Product Has No Code'}}</td>  --}}
                                                {{--  <td>{{ $orderRecord_item['product_details']['image']}}</td>  --}}
                                                {{--  <td>
                                    @if (!empty($orderRecord_item['product_details']['image']))
                                        <img src="{{ asset('storage/'.$product_img_path.'/' .$orderRecord_item['product_details']['image']) }}"
                                            alt="image">
                                    @elseif(empty($admin_by_type['photo']))
                                        <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                            alt="profile" />
                                    @endif</td>  --}}


                                                {{--  @json($orderRecord_item['product_quantity'])  --}}
                                                <td>{{ isset($orderRecord_item['product_quantity']) ? $orderRecord_item['product_quantity'] . 'x' : '' }}
                                                </td>
                                                <td>{{ isset($orderRecord_item['product_price']) ? $orderRecord_item['product_price'] : '' }}
                                                </td>
                                                <td>{{ isset($orderRecord_item['sub_total']) ? $orderRecord_item['sub_total'] : '' }}
                                                </td>


                                            </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <hr>

                        <div class="rest">
                            <div style="float: right">Subtotal: GH₵
                                {{ !empty($orderRecord_) ? $orderRecord_['sub_total'] : '' }}</div><br>
                            <div style="float: right">Tax: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['vat'] : '' }}
                            </div><br>
                            <div style="float: right">Discount: GH₵
                                {{ !empty($orderRecord_) ? $orderRecord_['discount'] : '' }}</div><br>
                            <div style="float: right">RECEIPT TOTAL: GH₵
                                {{ !empty($orderRecord_) ? number_format($orderRecord_['total'], 2) : '' }}</div><br>
                            <br>
                            <div>Amount Tendered: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['pay'] : '' }}</div>
                            <div>Change: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['due'] : '' }}</div><br>
                        </div>
                        <hr>

                        <div style="text-align: center;" style="font-size: 11px;"><b>

                          <i class=""></i>  Thank You And We hope To See You Again Soon</b></div>
                                <br>

                        <div style="text-align: center;" style="font-size: 11px;"><b>#SystemsMadeByZaid</b> 0240040834

                        </div>


                    </div>

                    <button id="print-me" class="btn btn-sm bg-primary text-white">
                        <i class="mdi mdi-printer-alert" style="font-size:20px"></i>
                    </button>
                </div>




                {{--  My own start here  --}}

            </div>
        </div>
    </div <!-- Modal -->




</div>
