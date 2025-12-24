<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{ $sale->products->first()->product_name ?? 'No Product' }}
        @if($sale->products->count() > 1)
            <small>+{{ $sale->products->count() - 1 }} produk lainnya</small>
        @endif
    </title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{asset('admin/css/sale.css')}} rel="stylesheet">
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

                <div class="order-name">
                    <p class="font-weight-bold">
                        {{ $sale->products->first()->product_name ?? 'No Product' }}
                        @if($sale->products->count() > 1)
                            <small>+{{ $sale->products->count() - 1 }} produk lainnya</small>
                        @endif
                    </p>
                </div>

            </div>

            <div class="main-info-order">
                <div class="info-left">
                    @if($sale->products->first() && $sale->products->first()->product_img)
                        <img src={{ asset('storage/'. $sale->products->first()->product_img) }} alt="image-emp" class="image-order" style="width: 470px; max-height: 325px; object-fit: cover;">
                    @endif

                    <div class="status-buy">
                        <p class="info-title">Status Pesanan</p>
                        <p class="status-order">{{$sale->sales_status}}</p>
                    </div>
                </div>

                <div class="info-order-container">

                    <div class="info-order" style="max-height: 325px;">
                        <p class="info-title">Data Customer</p>
                        <div class="info-inti">
                            <p>Id Sales: <span>{{$sale->sales_id}}</span></p>
                            <p>Customer: <span>{{ $sale->customers->customer_name ?? 'Guest' }}</span></p>
                            <p>Pay Method: <span>{{ $sale->payments->payment_name }}</span></p>
                            <p>Order Method: <span>{{ $sale->order_method == 1 ? 'Cafe' : 'Online' }}</span></p>
                            <p>Sales Date: <span>{{ $sale->created_at->format('d M Y, H:i') }}</span></p>
                            <p>Address: <span>{{$sale->customers->customer_address}}</span></p>
                        </div>
                    </div>
                    
                    <div class="status-pay">
                        <p class="info-title">Status Payment</p>
                        <p class="status-payment">{{ $sale->pay_status == 1 ? 'Paid' : 'Unpaid' }}</p>
                    </div>
 
                </div>

                <div class="info-right">
                    <div class="list-order" style="justify-content: flex-start; max-height: 325px;">
                        <h2 class="list-order-title">Daftar Pesanan</h2>

                        <div class="list-item">
                            @foreach ($sale->products as $product)
                                <div class="list">
                                    <div class="inner-list">
                                        <img src="{{ asset('storage/' . $product->product_img) }}" alt="">
                                        <div class="inner-list-text">
                                            <span class="item">{{ $product->product_name }}</span>
                                            <div class="preview">
                                                <span>{{ $product->pivot->order_quantity }} x Rp {{ number_format($product->product_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="total">
                                        <span>Rp {{ number_format($product->subtotal_item, 0, ',', '.') }}</span>
                                    </div>

                                </div>
                            @endforeach
                            
                            
                        </div>

                        
                    </div>

                    <div class="info-total">
                        <p class="total-title">Total Pembayaran</p>
                    
                        <div class="total-item">
                            <span>Total:</span>
                            <span>Rp {{ number_format($total_akhir, 0, ',', '.') }}</span>
                        </div>
                        <div class="total-item">
                            <span>Total Diskon:</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="total-item">
                            <span>Total Ongkir:</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="total-item-bold">
                            <span>Total Belanja:</span>
                            <span>Rp {{ number_format($total_akhir, 0, ',', '.') }}</span>
                        </div>
                        
                    </div>
                </div>

                

            </div>

            
            
        </main>

    </div>

    <!--Script-->

    <!--ApexChart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/5.3.5/apexcharts.min.js" integrity="sha512-dC9VWzoPczd9ppMRE/FJohD2fB7ByZ0VVLVCMlOrM2LHqoFFuVGcWch1riUcwKJuhWx8OhPjhJsAHrp4CP4gtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--JS SOURCE-->
    <script src={{asset('admin/js/sale.js')}}></script>
</body>
</html>