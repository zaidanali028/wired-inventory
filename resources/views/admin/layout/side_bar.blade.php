<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link
            @if (Session::get('page') == 'pos') bg-dark text-primary @endif"

            " href="{{ url('admin/pos') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">POS</span>
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
                                        class="nav-link  @if (Session::get('customers-management') == 'subscribers') bg-white text-primary @endif"
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
                @else
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false"
                            aria-controls="ui-basic4">
                            <i class="ti-settings menu-icon"></i>
                            <span class="menu-title">Vendor Details</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic4">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a
                                        class="nav-link  @if (Session::get('page') == 'personal') bg-white text-primary @endif"
                                        href="{{ url('admin/update-vendor-details/personal') }}">Update Personal
                                        Details</a>
                                </li>
                                <li class="nav-item"> <a
                                        class="nav-link  @if (Session::get('page') == 'business') bg-white text-primary @endif"
                                        href="{{ url('admin/update-vendor-details/business') }}">Update Business
                                        Detailss</a>
                                </li>
                                <li class="nav-item"> <a
                                        class="nav-link  @if (Session::get('page') == 'bank') bg-white text-primary @endif"
                                        href="{{ url('admin/update-vendor-details/bank') }}">Update Bank Details</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                            aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Form elements</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic
                                        Elements</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link
                            @if (Session::get('page') == 'dashboard') bg-white text-primary @endif"
                            data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                            <i class="mdi mdi-chart-areaspline menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="pages/charts/chartjs.html">ChartJs</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false"
                            aria-controls="tables">
                            <i class="icon-grid-2 menu-icon"></i>
                            <span class="menu-title">Tables</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic
                                        table</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false"
                            aria-controls="icons">
                            <i class="icon-contract menu-icon"></i>
                            <span class="menu-title">Icons</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="icons">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi
                                        icons</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">User Pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login
                                    </a></li>
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html">
                                        Register </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false"
                            aria-controls="error">
                            <i class="icon-ban menu-icon"></i>
                            <span class="menu-title">Error pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="error">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html">
                                        404 </a></li>
                                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html">
                                        500 </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/documentation/documentation.html">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">Documentation</span>
                        </a>
                    </li>
                </ul>
</nav>
