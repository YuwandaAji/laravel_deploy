<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href={{asset('employees/css/cashier.css')}}>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <!--navbar-->

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
    <!--Navbar End-->

    <!--topside start-->
    <topside>
        
    
        <div class="main-feature">

            <div class="main-title">
                <p class="font-weight-bold">CASHIER NONCHALANT COFFE</p>
            </div>

            <div class="feature-right">
                <form class="search" method="get" action={{ url("employees/cashier_search") }}>
                    <input type="search" placeholder="Search" class="search-input" name="search">
                    <button type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </form>

            </div>
        </div>
        
    </topside>
    <!--Topside End-->

    <!--Main start-->
    <main>

        <div class="column">
            <h2>New</h2>
            <p>Rp {{ number_format($totalNew, 0, ',', '.') }}</p>
            
            @foreach ($newSales as $sale)
                <div class="card" draggable="true">
                    <div class="card-header">
                        <a href={{ url("employees/cashier/$sale->sales_id") }}>
                            <span class="name">{{ $sale->customers->customer_name }}</span>
                            @if($sale->customers->customer_img)
                                <img src={{ asset('storage/'. $sale->customers->customer_img) }} alt="image-emp" class="custpic">
                            @else
                                <img src="{{ asset('employees/img/default_profile.png') }}" alt="default_image" class="custpic">
                            @endif
                        </a>
                    </div>
                    <span>Rp {{ number_format($sale->total_belanja, 0, ',', '.') }}</span>
                    
                    <div class="tags">
                        @foreach($sale->products as $product)
                            @php
                                $tagClass = '';
                                if($product->product_category == 'Snack') $tagClass = 'tag-snack';
                                elseif($product->product_category == 'Coffee') $tagClass = 'tag-coffee';
                                elseif($product->product_category == 'Signature') $tagClass = 'tag-signature';
                            @endphp
                            <span class="tag {{ $tagClass }}">{{ $product->product_name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="column">
            <h2>Prepared</h2>
            <p>Rp {{ number_format($totalPrepared, 0, ',', '.') }}</p>
            
            @foreach ($preparedSales as $sale)
                <div class="card" draggable="true">
                    <div class="card-header">
                        <a href={{ url("employees/cashier/$sale->sales_id") }}>
                            <span class="name">{{ $sale->customers->customer_name }}</span>
                            @if($sale->customers->customer_img)
                                <img src={{ asset('storage/'. $sale->customers->customer_img) }} alt="image-emp" class="custpic">
                            @else
                                <img src="{{ asset('employees/img/default_profile.png') }}" alt="default_image" class="custpic">
                            @endif
                        </a>
                    </div>
                    <span>Rp {{ number_format($sale->total_belanja, 0, ',', '.') }}</span>
                    
                    <div class="tags">
                        @foreach($sale->products as $product)
                            @php
                                $tagClass = '';
                                if($product->product_category == 'Snack') $tagClass = 'tag-snack';
                                elseif($product->product_category == 'Coffee') $tagClass = 'tag-coffee';
                                elseif($product->product_category == 'Signature') $tagClass = 'tag-signature';
                            @endphp
                            <span class="tag {{ $tagClass }}">{{ $product->product_name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="column">
            <h2>Delivery</h2>
            <p>Rp {{ number_format($totalDelivery, 0, ',', '.') }}</p>
            
            @foreach ($deliverySales as $sale)
                <div class="card" draggable="true">
                    <div class="card-header">
                        <a href={{ url("employees/cashier/$sale->sales_id") }}>
                            <span class="name">{{ $sale->customers->customer_name }}</span>
                            @if($sale->customers->customer_img)
                                <img src={{ asset('storage/'. $sale->customers->customer_img) }} alt="image-emp" class="custpic">
                            @else
                                <img src="{{ asset('employees/img/default_profile.png') }}" alt="default_image" class="custpic">
                            @endif
                        </a>
                    </div>
                    <span>Rp {{ number_format($sale->total_belanja, 0, ',', '.') }}</span>
                    
                    <div class="tags">
                        @foreach($sale->products as $product)
                            @php
                                $tagClass = '';
                                if($product->product_category == 'Snack') $tagClass = 'tag-snack';
                                elseif($product->product_category == 'Coffee') $tagClass = 'tag-coffee';
                                elseif($product->product_category == 'Signature') $tagClass = 'tag-signature';
                            @endphp
                            <span class="tag {{ $tagClass }}">{{ $product->product_name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="column">
            <h2>Done</h2>
            <p>Rp {{ number_format($totalDone, 0, ',', '.') }}</p>
            
            @foreach ($doneSales as $sale)
                <div class="card" draggable="true">
                    <div class="card-header">
                        <a href={{ url("employees/cashier/$sale->sales_id") }}>
                            <span class="name">{{ $sale->customers->customer_name }}</span>
                            @if($sale->customers->customer_img)
                                <img src={{ asset('storage/'. $sale->customers->customer_img) }} alt="image-emp" class="custpic">
                            @else
                                <img src="{{ asset('employees/img/default_profile.png') }}" alt="default_image" class="custpic">
                            @endif
                        </a>
                    </div>
                    <span>Rp {{ number_format($sale->total_belanja, 0, ',', '.') }}</span>
                    
                    <div class="tags">
                        @foreach($sale->products as $product)
                            @php
                                $tagClass = '';
                                if($product->product_category == 'Snack') $tagClass = 'tag-snack';
                                elseif($product->product_category == 'Coffee') $tagClass = 'tag-coffee';
                                elseif($product->product_category == 'Signature') $tagClass = 'tag-signature';
                            @endphp
                            <span class="tag {{ $tagClass }}">{{ $product->product_name }}</span>
                            <span>debug: "{{ $product->product_category }}"</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src={{asset('employees/js/cashier.js')}}></script>
</body>
</html>