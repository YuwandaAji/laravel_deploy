<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Payments</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{ asset('admin/css/payments.css') }} rel="stylesheet">
</head>
<body>
    <div class="grid-container">

        <!--HEADER-->

        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-symbols-outlined">menu</span>
            </div>

            <div class="header-left">
                <h2>Welcome <span class="name">{{ Auth::guard('employees')->user()->employee_name }}</span></h2>
            </div>

            <div class="header-right">
                <div class="user" onclick="subMenu()">
                    <span>{{ Auth::guard('employees')->user()->employee_name }}</span>
                    @if(Auth::guard('employees')->user()->employee_img)
                        <img src="{{ asset('storage/' . Auth::guard('employees')->user()->employee_img) }}" alt="profil_image">
                    @else
                        <img src="{{ asset('admin/img/default_profile.png') }}" alt="default_image">
                    @endif
                </div>
            </div>

            <div class="submenu-wrap" id="submenu">
                <div class="submenu">
                    <a href="{{url('admin/login')}}" class="submenu-link">
                        <span class="material-symbols-outlined">logout</span>
                        <p>Log Out</p>
                    </a>
                </div>
            </div>

        </header>
        <!--END HEADER-->

        <!--SIDEBAR-->

        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <img src={{ asset("admin/img/logo.jpg") }} alt="logo-brand">
                    <p>NONCHALANT COFFE</p>
                </div>
                <span class="material-symbols-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <a href={{ url('admin/dashboard') }}>Dashboard</a> 
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/employees') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">supervisor_account</span>
                    <a href={{ url('admin/employees') }}>Karyawan</a>  
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/customers') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">groups</span>
                    <a href={{ url('admin/customers') }}>Customer</a>  
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/products') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">local_cafe</span>
                    <a href={{ url('admin/products') }}>Produk</a>  
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/payments') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">payments</span>
                    <a href={{ url('admin/payments') }}>Pembayaran</a>  
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/sales') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">list_alt</span>
                    <a href={{ url('admin/sales') }}>Pesanan</a>  
                </li>
                <li class="sidebar-list-item {{ Request::is('admin/feedbacks') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">feedback</span>
                    <a href={{ url('admin/feedbacks') }}>Feedback</a>  
                </li>
            </ul>
        </aside>
        <!--END SIDEBAR-->

        <!--MAIN-->

        <main class="main-container">

            <div class="main-feature">

                <div class="main-title">
                    <p class="font-weight-bold">PEMBAYARAN NONCHALANT COFFE</p>
                </div>

                <div class="feature-right">
                    <form class="search" method="get" action={{ url("admin/payments_search") }}>
                        <input type="search" placeholder="Search" class="search-input" name="search">
                        <button type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </form>

                    <div class="filter-container">
                        <div class="filter" id="btnFilter">
                            <span class="material-symbols-outlined">filter_list</span>
                        </div>

                        <ul class="menu-filter" id="filter">
                            <li class="filter-item"><a href="{{ url('admin/payments_search?category=E-Wallet') }}"><span>E-Wallet</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/payments_search?category=E-Bank') }}"><span>E-Bank</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/payments_search?category=COC') }}"><span>COC</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/payments_search?category=COD') }}"><span>COD</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main-card">
                @foreach ($payments as $payment)
                    <a href={{ url("admin/payments/$payment->payment_id") }} style="width: 150px;" class="card">
                        @if($payment->payment_img)
                            <img src={{ asset('admin/img/'. $payment->payment_img) }} alt="image-emp">
                        @endif
                        <div class="inner-card">
                            <p class="name-pay">{{ $payment->payment_name }}</p>
                            <div class="status" style="margin-right: 5px;">
                                <span class="material-symbols-outlined" style="color: {{ $payment->payment_status == 1 ? '#2ecc71' : '#e74c3c' }};">attach_money</span>
                            </div>
                            
                        </div>
                    </a>
                @endforeach
            </div>
        </main>

    </div>

    <!--JS SOURCE-->
    <script src={{asset('admin/js/payments.js')}}></script>
</body>
</html>