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
                                <h2 class="m-0 font-weight-bold text-primary">All Time Sales / Orders (By Each Employee)</h2>

                            </div>
                            @if (!empty($orders))
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Issued By
                                            </th>
                                            <th>

                                                Customer #
                                            </th>
                                            <th>Qty. Of Items Sold</th>
                                            <th>
                                                Sale Worth(IN GH₵)
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
                                                @if (Auth::guard('admin')->user())
                                                    <td>{{ $order['get_issued_admin']['name'] ?? ' NOT CAPTURED! ' }}
                                                    </td>
                                                @endif

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
                    @include('admin.layout.order-det')




                    {{--  My own start here  --}}

                </div>



                {{--  My own start here  --}}

            </div>
        </div>
    </div <!-- Modal -->




</div>
