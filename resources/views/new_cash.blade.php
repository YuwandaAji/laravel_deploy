<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir New</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href={{asset('employees/css/new_cash.css')}}
      rel="preconnect"
      href="https://fonts.googleapis.com"
    />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
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
        <div class="main-title">
            <p class="font-weight-bold">New Order</p>
        </div>
    </topside>
    <!--Topside End-->

    <!--Main Start-->
    <!-- Nama Customer -->
    <div class="nama-cust">
      <input type="text" id="namaCust" placeholder="Masukkan nama pelanggan">
    </div>

    <!-- Konten -->
    <div class="content">
      <!-- Bagian Menu -->
      <div class="menu-section">
        <h2>Menu</h2>

        <div class="category">
          <h3>Kopi</h3>
          <div class="items">
            @foreach($coffee as $item)
                <div class="item" 
                    data-id="{{ $item->product_id }}" 
                    data-name="{{ $item->product_name }}" 
                    data-price="{{ $item->product_price }}">
                    {{ $item->product_name }} 
                    <small>Rp {{ number_format($item->product_price, 0, ',', '.') }}</small>
                </div>
            @endforeach
          </div>
        </div>

        <div class="category">
          <h3>Snack</h3>
          <div class="items">
            @foreach($snack as $item)
                <div class="item" 
                    data-id="{{ $item->product_id }}" 
                    data-name="{{ $item->product_name }}" 
                    data-price="{{ $item->product_price }}">
                    {{ $item->product_name }} 
                    <small>Rp {{ number_format($item->product_price, 0, ',', '.') }}</small>
                </div>
            @endforeach
          </div>
        </div>

        <div class="category">
          <h3>Signature</h3>
          <div class="items">
            @foreach($signature as $item)
                <div class="item" 
                    data-id="{{ $item->product_id }}" 
                    data-name="{{ $item->product_name }}" 
                    data-price="{{ $item->product_price }}">
                    {{ $item->product_name }} 
                    <small>Rp {{ number_format($item->product_price, 0, ',', '.') }}</small>
                </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Bagian Total -->
      <div class="total-section">
        <div>
          <h2>Total Pesanan</h2>
          <ul id="orderList" class="order-list"></ul>
          <div class="total-item">
            <span>Subtotal</span>
            <span id="totalItem">Rp 0</span>
          </div>
          <div class="total total-item">
            <span>Total</span>
            <span id="totalAll">Rp 0</span>
          </div>
        </div>

        <div class="buttons">
          <button id="printNota">Print Nota & Siapkan</button>
          <button id="hapusPesanan" class="delete">Hapus Semua Pesanan</button>
        </div>
      </div>
    </div>
  </div>
  <script src={{asset('employees/js/new_cash.js')}}></script>
    <!--End Main-->
  </body>
</html>
