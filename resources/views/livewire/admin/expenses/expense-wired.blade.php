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
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h2 class="m-0 font-weight-bold text-primary">Expense List</h2> <a
                                    wire:click.prevent="newExpense" class="btn btn-primary float-right"
                                    style="margin-top: 6px; margin-right: 6px;">Add New Expense</a>
                            </div>
                            <div class="table-responsive">
                                <table id='' class="dataTable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Details #
                                            </th>
                                            <th>
                                                Amount
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Action
                                            </th>



                                        </tr>
                                    </thead>
                                    <tbody>



                                        @forelse ($Expenses as $Expense)
                                            <tr>

                                                <td class="text-capitalize">{{substr($Expense['details'] , 0, 48) }}...</td>
                                                <td class="text-capitalize">{{ $Expense['amount'] }}</td>


                                                <td class="">{{ empty($Expense['expense_date'])?'Date Was Not Recorded':$Expense['expense_date'] }}</td>
                                               <td>
                                                    <a wire:click.prevent="editExpense({{$Expense['id']}})"
                                                        style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>


                                                    <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                                        wire:click.prevent="deleteExpenseConfirm({{ $Expense['id'] }})"></a>
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
                                    Expenses</button>

                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $Expenses->links() }}
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
    <div wire:ignore.self class="modal  fade" id="add-Expense-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add-Expense-modal">Expense MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>

                </div>
                <div class="modal-body">
                    <div class="card">
                        <div  class="">
                            <div  class="card-body p-0">
                                <div  class="row">
                                    <div  class="col-lg-12">
                                        <div  class="login-form">
                                            <div  class="text-center">
                                                <h1  class="h4 text-gray-900 mb-4">{{ $addNewExpense?'Add Expense':'Edit Expense' }}</h1>
                                            </div>
                                            <form
                        wire:submit.prevent={{ $addNewExpense ? 'submitaddNewExpense' : 'updateExpense ' }}>


                                                <div  class="form-group">
                                                    <textarea wire:model.defer='inputs.details'  type="text" id="exampleInputFirstName" placeholder="Enter Expense Details"
                                                        rows="3" class="form-control
                                                        @error('details')
                                                        is-invalid
                                                            @enderror
                                                        "></textarea>
                                                    <!---->
                                                    @error('details')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                <div  class="form-group"><input
                                                    wire:model.defer='inputs.amount'
                                                        type="number" step="0.01" id="exampleInputFirstName"
                                                        placeholder="Enter Expense Amount" class="
                                                        form-control
                                                    @error('amount')
                                                    is-invalid
                                                        @enderror
                                                        ">
                                                    <!---->
                                                    @error('amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                </div>


                                                <div  class="form-group"><button
                                                        type="submit" class="btn btn-primary btn-block">{{ $btn_text }}</button>
                                                </div>
                                            </form>
                                            <div  class="text-center"></div>
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
