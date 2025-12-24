<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$sale->customers->customer_name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href={{asset('employees/css/detail.css')}}>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header">

        <div class="header-left">
            <h2>Welcome <span class="name">{{ Auth::guard('employees')->user()->employee_name }}</span></h2>
        </div>

        <div class="header-right">
            <div class="user" onclick="subMenu()">
                <span>{{ Auth::guard('employees')->user()->employee_name }}</span>
                @if(Auth::guard('employees')->user()->employee_img)
                    <img src="{{ asset('storage/' . Auth::guard('employees')->user()->employee_img) }}" alt="profil_image">
                @else
                    <img src="{{ asset('employees/img/default_profile.png') }}" alt="default_image">
                @endif
            </div>
        </div>

        <div class="submenu-wrap" id="submenu">
            <div class="submenu">
                <a href="{{url('employees/login')}}" class="submenu-link">
                    <span class="material-symbols-outlined">logout</span>
                    <p>Log Out</p>
                </a>
            </div>
        </div>

    </header>

    <!--Topside Start-->
    <topside>

        <div class="cust_name">
            <h2><b>{{$sale->customers->customer_name}}</b></h2>
        </div>

        <div class="status-stepper" id="btn-bar">
            <button type="button" 
                class="btn-custom {{ $sale->sales_status == 'New' ? 'active' : '' }}" 
                data-status="New" data-id="{{ $sale->sales_id }}">New</button>
                
            <button type="button" 
                class="btn-custom {{ $sale->sales_status == 'Prepared' ? 'active' : '' }}" 
                data-status="Prepared" data-id="{{ $sale->sales_id }}">Prepared</button>
                
            <button type="button" 
                class="btn-custom {{ $sale->sales_status == 'Delivery' ? 'active' : '' }}" 
                data-status="Delivery" data-id="{{ $sale->sales_id }}">Delivery</button>
                
            <button type="button" 
                class="btn-custom {{ $sale->sales_status == 'Done' ? 'active' : '' }}" 
                data-status="Done" data-id="{{ $sale->sales_id }}">Done</button>
        </div>

    </topside>
    <!--Topside End-->

    <!--Main Start-->
    <main>

        <div class="kiri">
            <div class="card">
                <h3>Information Order</h3>
                <p>No. Order : {{$sale->sales_id}}</p>
                <p>Payment Method : {{$sale->payments->payment_name}}</p>
                <p>Order Method: <span>{{ $sale->order_method == 1 ? 'Cafe' : 'Online' }}</span></p>
                <p>Address : {{$sale->customers->customer_address}} </p>
            </div>

            <div class="card">
                <h3>Detail Item</h3>
                @foreach($sale->products as $product)
                    <div class="item">
                        <p>{{ $product->pivot->order_quantity }} X {{ $product->product_name }}</p> 
                        <span>Rp {{ number_format($product->subtotal_item, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="kanan">

            <div class="card">
                <h3>Order Total</h3>
                <div class="item">
                    <p>Item Total</p> 
                    <span>Rp {{ number_format($total_akhir, 0, ',', '.') }}</span>
                </div>
                <div class="item">
                    <p>Ongkir</p> <span>Rp 0</span>
                </div>
                <div class="item">
                    <p>Diskon</p> <span>Rp 0</span>
                </div>
                <div class="total">
                    <b>Total</b> 
                    <b>Rp {{ number_format($total_akhir, 0, ',', '.') }}</b>
                </div>
                <div class="btnback">
                    <a href="{{url('employees/cashier')}}">Kembali ke Halaman Utama</a>
                </div>
            </div>

        </div>

    </main>
    <!--End Main-->

    <script src={{asset('employees/js/detail.js')}}></script>
</body>
</html>