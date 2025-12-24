<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <!-- Feather Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- My Style -->
    <link rel="stylesheet" href={{ asset('css/home.css') }}>

 
    
    </head>

    

  <body>
    <!-- Navbar Start -->
     <nav class="navbar">
        <div class="left-part">
            <img src="img/logo.jpg" alt="logo" class="logo">
            <span>Nonchalant Cafe</span>
        </div>
      

        <div class="navbar-nav">
            <a href="#Home">Home</a>
            <a href="#about">About</a>
            <a href="#menu">Menu</a>
            <a href="#contact">Kontak</a>
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
    <!-- Navbar End -->

    <!-- Hero section start -->
      <section class="hero" id="Home">
        <main class="content">
          <h1>Rasakan<span>Ketenangan</span> di setiap Tegukan</h1>
          <p>Temukan biji kopi pilihan dari kebun terbaik dunia. Kami menyajikan lebih dari sekadar secangkir Kopi, kami menyajikan sebuah ketenangan murni dari secangkir kopi</p>
          <a href="{{ url('order') }}" class="cta">Beli Sekarang</a>
        </main>
      </section>
    <!-- Hero section end -->

    <!-- About Section start -->
     <section id="about" class="about">
      <h2><span> Tentang</span> Kami</h2>
      <div class="row">
        <div class="about-img">
          <img src="{{ asset('img/tentangkami.jpeg') }}">
        </div>
        <div class="content">
          <h3>Kenapa harus Nonchalant Coffe?</h3>
          <p>Nonchalant coffe bukan hanya sebagai penyedia kopi, melainkan sebagai filosofi hidup, sikap tenang, santai, dan apa adanya tanpa harus tergesa-gesa oleh arus. Karena itulah nama "Nonchalant" dipilih karena mencerminkan elegansi, ketenangan, serta kebebasan dalam menikmati hidup yang sederhana namun bermakna</p>
        </div>
      </div>
     </section>
    <!-- About Section End -->

    <!-- Menu section start -->
     <section id="menu" class="menu">
      <h2><span>Menu</span> Kami</h2>
      <p>Setiap biji memiliki cerita. Kami memilihnya langsung dari petani lokal, memastikan kualitas premium dan jejak yang berkelanjutan. Kami ingin memberikan kualitas yang tinggi untuk anda.</p>
      <div class="row" style="gap: 35px;">
        @foreach ($products as $product)
            <a class="menu-card" href={{ url('order') }} style="text-decoration: none; color: white;">
                @if($product->product_img)
                    <img src={{ asset('storage/'. $product->product_img) }} alt="image-emp" class="img-item" style='width: 250px; height: 250px; border-radius:50%;'>
                @endif
                <h3 class="menu-card-title">- {{$product->product_name}} -</h3>
                <p class="menu-card-price">Rp {{$product->product_price}}</p>
            </a>
        @endforeach
        
      </div>
     </section>

    <!-- Contact section start -->
     <section id="contact" class="contact">
      <h2><span>Kontak</span> Kami</h2>
      <p>Terima kasih telah memilih kualitas. Kami berjanji akan terus menyajikan kopi terbaik dari bumi, langsung ke cangkir Anda. Mari bergabung dalam komunitas kami!</p>
      <div class="row">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15829.256096235058!2d112.72667499999997!3d-7.318578550000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb6551205733%3A0x32a9d1800d0cfc47!2sKetintang%2C%20Kec.%20Gayungan%2C%20Surabaya%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1760061098576!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        <form action="">
          <div class="input-group">
            <i data-feather="user"></i>
            <input type="text" placeholder="nama">
          </div>
          <div class="input-group">
            <i data-feather="mail"></i>
            <input type="text" placeholder="email">
          </div>
          <div class="input-group">
            <i data-feather="phone"></i>
            <input type="text" placeholder="no hp">
          </div>
          <button type="submit" class="btn">kirim pesan</button>
        </form>
      </div>
    </section>
    <!-- Contact section end -->
     
    <!-- Footer start -->
      <footer>
        <div class="socials">
          <a href="#"><i data-feather="instagram"></i></a>
          <a href="#"><i data-feather="twitter"></i></a>
          <a href="#"><i data-feather="facebook"></i></a>
        </div>

        <div class="links">
          <a href="#Home">Home</a>
          <a href="#about">Tentang kami</a>
          <a href="#menu">Menu</a>
          <a href="#contact">Kontak</a>
        </div>

        <div class="credit">
          <p>Created by <a href="">kelompokSepuluh</a>. | &copy;2025</p>
        </div>

      </footer>
    <!-- Footer End -->

    


    <!-- Feather Icons -->
<script>
  feather.replace()
</script>
    <!-- Javascript -->
     <script src="css/homepage.js"></script>
    <script>
      feather.replace();
    </script>

    <!-- Alpinejs -->
     <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
     
     <!-- App -->
     <script src={{ asset('js/home.js') }}></script>
     <script src="https://unpkg.com/feather-icons"></script>
  </body>
</html>
