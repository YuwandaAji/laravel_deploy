<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Produk</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{asset('admin/css/products.css')}} rel="stylesheet">

    
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
                        <img src="{{ Auth::guard('employees')->user()->employee_img }}" alt="profil_image">
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
            </ul>
        </aside>
        <!--END SIDEBAR-->

        <!--MAIN-->

        <main class="main-container">
            <div class="main-title">
                <p class="font-weight-bold">PRODUK NONCHALANT COFFE</p>
            </div>

            <div class="main-feature">

                <div class="feature-left">
                    <button id="button-new" class="add-btn">+ Add</button>
                </div>

                <div class="feature-right">
                    <form class="search" method="get" action={{ url("admin/products_search") }}>
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
                            <li class="filter-item"><a href="{{ url('admin/products_search?category=Coffe') }}"><span>Coffe</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/products_search?category=Signature') }}"><span>Signature</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/products_search?category=Snack') }}"><span>Snack</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main-card" style="display: flex; flex-wrap: wrap; gap: 20px; width: 100%; padding: 20px 0;">
                @foreach ($products as $product)

                    <a class="card" href={{ url("admin/products/$product->product_id") }} style="width: 150px;">
                        @if($product->product_img)
                            <img src="{{ $product->product_img }}" alt="image-emp" id="img-view" class="image-item">
                        @endif
                        <p class="name-produk">{{$product->product_name}}</p>
                        <p class="price">Rp {{ $product->product_price }}</p>
                    </a>
                @endforeach

            </div>

            <!--Pop Up New-->

            <div class="popup-new" id="form-new">
                <form class="form" id="form-apper" method="POST" action={{ url('admin/products_add') }} enctype="multipart/form-data">
                    @csrf

                    <div class="inner-form">

                        <div class="top-part">
                            
                            <div class="editable-name">
                                <span id="finalText" style="display: none;"></span>
                                <textarea id="name-input" placeholder="Nama Produk" name="name" rows="1" spellcheck="true" required></textarea>
                            </div>

                            <div class="img-container">
                                
                                <img src={{ asset("admin/img/default-camera.jpg") }} id="img-preview">
                                
                                <input type="file" accept="image/*" name="product_img" id="input-file" hidden required>
                            </div>

                        </div>
                        

                        <div class="input-text">
                            
                            <div class="left-part">

                                <div class="inner-left">
                                    <div class="price-form">
                                        <label class="prc-label">Harga</label>
                                        <div class="inner-prc">
                                            <span class="prefix">Rp</span>
                                            <input type="text" name="price" id="prcInput" autocomplete="off" placeholder="0.00" required>
                                        </div>
                                    
                                    </div>

                                    <div class="size-form">
                                        <label class="size-label">Size</label>
                                        <input type="text" id="sizeInput" name="size" style="display: block;" placeholder="" required>
                                        
                                    </div>

                                    <div class="stock-form">
                                        <label class="stock-label">Stock</label>
                                        <input type="text" name="stock" id="stockInput" style="display: block;" placeholder="" required>
                                        
                                    </div>

                                    <div class="cat-form">
                                        <label class="cat-label">Category</label>
                                        <div class="select-box">
                                            <input type="text" class="input-cat" placeholder="" autocomplete="off">
                                            <input type="hidden" name="category" id="catId" required>
                                            <ul class="select-options">
                                                <li data-value="Coffe">Coffe</li>
                                                <li data-value="Signature">Signature</li>
                                                <li data-value="Snack">Snack</li>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="deskripsi-form">
                                <label class="deskripsi-label">Deskripsi</label>

                                    <textarea id="deskripsiInput" name="description" style="display: block;" required></textarea>
             
                            </div>
                            
                        </div>

                        
                    </div>
                    
                    <div class="btn-popup">
                        <button id="btn-cancel" type="button">Cancel</button>
                        <button id="btn-save" type="submit">Save</button>
                    </div>
                    

                </form>
            </div>

              
        </main>

    </div>

    



    <!--JS SOURCE-->
    <script src={{asset('admin/js/products.js')}}></script>

</body>
</html>