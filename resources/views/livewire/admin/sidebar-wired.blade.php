<div>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">

                <a class="nav-link" id="next-page-link"  href="{{ url('admin/dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if (Session::get('page') == 'pos') bg-primary text-primary @endif"

                " href="{{ url('admin/pos') }}">
                    <i class="mdi mdi-fingerprint" style="font-size:20px"></i>
                    <span class="menu-title">POS</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if (Session::get('page') == 'orders') bg-primary text-primary @endif"

                " href="{{ url('admin/orders') }}">
                    <i class="mdi mdi-cart-outline" style="font-size:20px"></i>
                    <span class="menu-title">ORDERS</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if (Session::get('page') == 'expenses') bg-primary text-primary @endif"

                " href="{{ url('admin/expenses') }}">
                    <i class="mdi mdi-trending-up" style="font-size:20px"></i>
                    <span class="menu-title">EXPENSES</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="ti-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a
                                class="nav-link
                                @if (Session::get('page') == 'update-password') bg-white text-primary @endif"
                                href="{{ url('admin/update-password') }}" ">Update My
                                Password</a></li>
                        <li class="nav-item"> <a class="nav-link  @if (Session::get('page') == 'update-details') bg-white text-primary @endif" href="{{ url('admin/update-details') }}">Update My
                                Details</a></li>

                    </ul>
                </div>
            </li>
             @if ($admin_details['type'] == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false"
                                aria-controls="ui-basic2">
                                <i class="mdi mdi-account-check"></i>
                                <span class="menu-title">User Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic2">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a
                                        class="nav-link  @if (Session::get('page') == 'admin-management') bg-white text-primary @endif"
                                        href="{{ url('admin/admin-management') }}">Admin(s)</a></li>
                                    <li class="nav-item"> <a
                                            class="nav-link  @if (Session::get('page') == 'employee-management') bg-white text-primary @endif"
                                            href="{{ url('admin/employee-management') }}">Employee(s)</a></li>

                                    <li class="nav-item"> <a
                                            class="nav-link  @if (Session::get('page') == 'customers-management') bg-white text-primary @endif"
                                            href="{{ url('admin/customers-management') }}">Customer(s)</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false"
                                aria-controls="ui-basic3">
                                <i class="mdi mdi-worker"></i>
                                <span class="menu-title">Supplier Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic3">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a
                                            class="nav-link  @if (Session::get('page') == 'supplier-management') bg-white text-primary @endif"
                                            href="{{ url('admin/supplier-management') }}">Supplier(s)</a></li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false"
                                aria-controls="ui-basic4">
                                <i class="mdi mdi-basket-unfill"></i>
                                <span class="menu-title">Catalogue Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic4">
                                <ul class="nav flex-column sub-menu">

                                    <li class="nav-item"> <a
                                            class="nav-link  @if (Session::get('page') == 'categories') bg-white text-primary @endif"
                                            href="{{ url('admin/categories') }}">
                                             Categories</a></li>


                                    <li class="nav-item"> <a
                                            class="nav-link  @if (Session::get('page') == 'products') bg-white text-primary @endif"
                                            href="{{ url('admin/products') }}">Products</a>
                                    </li>

                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                                aria-controls="form-elements">
                                <i class="mdi mdi-square-inc-cash mr-2" style="font-size:20px"></i>
                                <span class="menu-title">Salary Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="form-elements">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link  @if (Session::get('page') == 'salary-management') bg-white text-primary @endif"
                                        href="{{ url('admin/salary-management') }}">Issue Salarie(s)</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link  @if (Session::get('page') == 'all-salaries') bg-white text-primary @endif"
                                        href="{{ url('admin/all-salaries') }}">All Issues Salarie(s)</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif

                    </ul>
    </nav>
</div>
