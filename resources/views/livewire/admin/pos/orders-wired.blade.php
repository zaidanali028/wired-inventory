<div class="main-panel">
    <x-spinner />

    <div class="c
        fontent-wrapper">
        @include('admin.layout.auth_welcome')


        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">All Orders List</h2> <a wire:click.prevent="orders_today"
                                    class="btn btn-primary float-right" style="margin-top: 6px; margin-right: 6px;">Orders Today</a>
                            </div>
                            @if(!empty($orders))
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



                                        @forelse ($orders as $order)
                                            <tr>

                                                <td class="text-capitalize">{{ $order['get_customer']['name'] }}</td>
                                                <td class="text-capitalize">{{ $order['qty'] }}</td>
                                                <td class="text-capitalize">₵{{ $order['total'] }}</td>
                                                <td class="text-capitalize">{{ $order['payBy'] }}</td>

                                                <td>{{ $order['order_date'] }}</td>
                                                <td><button wire:click.prevent="show_view_order({{ $order['id'] }})"
                                                        class="btn btn-sm bg-primary text-white">View Order</button>
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
                {{--  modal -body  --}}
                <div class="modal-body">
                    <div class="card">
                        <div  class="row mb-3">
                            <div  class="col-xl-6 col-lg-6 border border-primary border-2 border-dashed">
                                <div  class="card mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h5  class="m-0 font-weight-bold text-primary">Order Details
                                        </h5>
                                    </div>
                                    <div  class="card-body ">
                                        <div  class="table-responsive">
                                            <ul  class="list-group">
                                                <li  class="list-group-item"><b

                                                        >Name : </b>{{!empty($orderRecord_)? $orderRecord_['get_customer']['name']:''  }}</li>
                                                <li  class="list-group-item"><b
                                                        >Phone : </b>{{!empty($orderRecord_)? $orderRecord_['get_customer']['phone']:''  }}</li>
                                                <li  class="list-group-item"><b
                                                        >Address : </b>{{!empty($orderRecord_)? $orderRecord_['get_customer']['address']:''  }} </li>
                                                        <li  class="list-group-item"><b
                                                            >E-mail : </b>{{!empty($orderRecord_)? $orderRecord_['get_customer']['email']:''  }}</li>
                                                <li  class="list-group-item"><b

                                                        >Date : </b>{{!empty($orderRecord_)? $orderRecord_['order_date']:''  }}</li>
                                                <li  class="list-group-item"><b >Paid
                                                        Through : </b>{{!empty($orderRecord_)? $orderRecord_['payBy']:''  }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="col-xl-6 col-lg-6 border border-primary border-2 border-dashed">
                                <div  class="card mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h5  class="m-0 font-weight-bold text-primary">Order Details
                                        </h5>
                                    </div>
                                    <div  class="card-body">
                                        <div  class="table-responsive">
                                            <ul  class="list-group">
                                                <li  class="list-group-item"><b >Sub
                                                        Total : </b>GH₵ {{!empty($orderRecord_)? $orderRecord_['sub_total']:''  }}</li>
                                                <li  class="list-group-item"><b >Vat
                                                        : {{!empty($orderRecord_)? $orderRecord_['vat']:''  }} </b>%</li>
                                                <li  class="list-group-item"><b
                                                        >Total :GH₵  {{!empty($orderRecord_)? $orderRecord_['total']:''  }}  </b>$</li>
                                                <li  class="list-group-item"><b >Paid
                                                        Amount :GH₵  {{!empty($orderRecord_)? $orderRecord_['pay']:''  }} </b></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="row mb-3">
                            <div  class="col-xl-12 col-lg-12 border border-primary border-2 border-dashed shadow-lg">
                                <div  class="card mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h5  class="m-0 font-weight-bold text-primary">Ordered
                                            Products</h5>
                                    </div>
                                    <div  class="card-body">
                                        <div  class="table-responsive">
                                            <table  class="table align-items-center table-flush">
                                                <thead  class="thead-light">
                                                    <tr >
                                                        <th >Product Name</th>
                                                        <th >Code</th>
                                                        <th >Image</th>
                                                        <th >Qty</th>
                                                        <th >Unit Price</th>
                                                        <th >Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                   @if(!empty($orderRecord_))
                                                   @forelse ($orderRecord_['get_order_detail'] as $orderRecord_item )
                                                  <tr>
                                                    {{--  @json($orderRecord_item['product_details']["product_name"])  --}}
                                                    <td>{{ $orderRecord_item['product_details']['product_name']}}</td>
                                                    <td>{{ !empty($orderRecord_item['product_details']['product_code'])?$orderRecord_item['product_details']['product_code']:'Product Has No Code'}}</td>
                                                    {{--  <td>{{ $orderRecord_item['product_details']['image']}}</td>  --}}
                                                    <td>
                                                        @if (!empty($orderRecord_item['product_details']['image']))
                                                            <img src="{{ asset('storage/'.$product_img_path.'/' .$orderRecord_item['product_details']['image']) }}"
                                                                alt="image">
                                                        @elseif(empty($admin_by_type['photo']))
                                                            <img src="{{ asset('admin/images/faces/face20.jpg') }}"
                                                                alt="profile" />
                                                        @endif</td>


                                                    {{--  @json($orderRecord_item['product_quantity'])  --}}
                                                   <td> {{ isset($orderRecord_item['product_quantity'])?$orderRecord_item['product_quantity'].'x':''}}</td>
                                                   <td>₵{{ isset($orderRecord_item['product_price'])?$orderRecord_item['product_price']:''}}</td>
                                                   <td> ₵{{ isset($orderRecord_item['sub_total'])?$orderRecord_item['sub_total']:''}}</td>


                                                  </tr>
                                                  @empty
                                                  <tr>
                                                      <td colspan="2"> No Data To Show!</td>
                                                  </tr>
                                              @endforelse

                                               
                                                   @endif
                                                </tbody>
                                            </table>
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
</div>
