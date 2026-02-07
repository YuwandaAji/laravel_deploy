<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Orders</title>
    <!-- Feather Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- My Style -->
    <link rel="stylesheet" href={{ asset('css/your_order.css') }}>

 
    
    </head>

    

  <body>
    <!-- Navbar Start -->
     <nav class="navbar">
        <div class="left-part">
            <img src="img/logo.jpg" alt="logo" class="logo">
            <span>Nonchalant Cafe</span>
        </div>
      

        <div class="navbar-nav">
            <a href="{{ url('home#Home') }}">Home</a>
            <a href="{{ url('home#about') }}">About</a>
            <a href="{{ url('home#menu') }}">Menu</a>
            <a href="{{ url('home#contact') }}">Contact</a>
            <a href={{ url('your_order') }} class="track-link">Your Order</a>
        </div>

        <div class="right-part">
            <a href="{{ url('order') }}">
                <i data-feather="shopping-bag"></i>
            </a>
            <a href="{{ url('order') }}">
                <i data-feather="shopping-cart"></i>
            </a>
            <a href="#" id="coffe-menu"><i data-feather="menu"></i></i></a>
            <div class="header-right">
                <div class="user" onclick="subMenu()">
                    <span>{{ Auth::guard('web')->user()->customer_name }}</span>
                    @if(Auth::guard('web')->user()->customer_img)
                        <img src="{{ asset('storage/' . Auth::guard('web')->user()->customer_img) }}" alt="profil_image">
                    @else
                        <img src="{{ asset('/img/default_profile.png') }}" alt="default_image">
                    @endif
                </div>
                
            </div>

            <div class="submenu-wrap" id="submenu">
                <div class="submenu">

                    <a href="{{url('profile')}}" class="submenu-link">
                        <span class="material-symbols-outlined">person_2</span>
                        <p class="profile">Profile</p>
                    </a>
                    <a href="{{url('login')}}" class="submenu-link">
                        <span class="material-symbols-outlined">logout</span>
                        <p class="logout">Log Out</p>
                    </a>
                    
                </div>
            </div>
        </div>
        
      </div>

     </nav>

     <main class="main-container">
            

            <div class="main-feature">

                <div class="main-title">
                    <p class="font-weight-bold">PESANAN ANDA</p>
                </div>

                <div class="feature-right">
                    <form class="search" method="get" action={{ url("your_order_search") }}>
                        <input type="search" placeholder="Search" class="search-input" name="search">
                        <button type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="main-list">
                @foreach ($sales as $sale)
            
                    <a href={{ url("your_order/$sale->sales_id") }} class="list">
                        <div class="inner-list">
                            @if($sale->products->first() && $sale->products->first()->product_img)
                                <img src={{ asset('storage/'. $sale->products->first()->product_img) }} alt="image-emp">
                            @endif
                            <div class="inner-list-text">
                                <span class="item">{{ $sale->products->first()->product_name ?? 'No Product' }}
                                    @if($sale->products->count() > 1)
                                        <small>+{{ $sale->products->count() - 1 }} produk lainnya</small>
                                    @endif
                                </span>
                                <div class="preview">
                                    <span>Id Sales: {{$sale->sales_id}}</span>
                                    <span>{{ $sale->products->count() }} Produk</span>
                                    <span>Total: Rp {{ number_format($sale->total_nominal, 0, ',', '.') }}</span>
                                    <span>Waktu: {{ $sale->created_at->format('d M Y, H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="status">
                            <span class="pstatus">{{$sale->sales_status}}</span>
                        </div>
                    
                    </a>
                @endforeach
                
                </div>
            </div>
        </main>

    <script src={{ asset('js/home.js') }}></script>

  </body>
</html>