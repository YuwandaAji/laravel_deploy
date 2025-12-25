<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $product->product_name }}</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{asset('admin/css/product.css')}} rel="stylesheet">
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
                    <a href="login_nonchalant.html" class="submenu-link">
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

                <div class="item-name">
                    <p class="font-weight-bold">{{ $product->product_name }}</p>
                </div>

                <div class="feature-right">
                    <button id="btnEdit">Edit</button>
                    <button id="btnDelete">Delete</button>
                </div>
            </div>

            <div class="main-info-item">
                <div class="info-left">
                    @if($product->product_img)
                        <img src={{ asset('storage/'. $product->product_img) }} alt="image-emp" class="image-item" style="width: 450px; max-height: 325px; object-fit: cover;">
                    @endif

                    <div class="info-order-container" style="margin-top: 10px;">
                        <div class="info-order">
                            <p class="order-title">Today Sales</p>
                            <p class="info-text">{{$todaySales}}</p>
                        </div>

                        <div class="info-order">
                            <p class="order-title">Revenue</p>
                            <p class="info-text">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>

                        <div class="info-order">
                            <p class="order-title">Stock</p>
                            <p class="info-text">{{$product->product_stock}}</p>
                        </div>
                    </div>
                </div>

                
                <div class="info-right">

                    <div class="info-item" style="width: 300px; height: 325px; max-height: 325px overflow-y: auto;">
                        <p class="item-title">Rincian Produk</p>
                        <div class="info-inti">
                            <p>Nama: <span>{{$product->product_name}}</span></p>
                            <p>Harga: <span>Rp {{$product->product_price}}</span></p>
                            <p>Size: <span>{{$product->product_size}}</span></p>
                            <p>Deskripsi: <span>{{$product->product_description}}</span></p>
                        </div>
                    </div>

                    <div class="info-diskon">
                        <p class="diskon-title">Diskon</p>
                        <p class="diskon-text">-</p>
                    </div>                    
                </div>

                <div class="chart">
                    <p class="chart-title">Sales By Month</p>
                     <div id="line-chart"></div>
                </div>
            </div>
            
            <!--Pop Up edit-->

            <div class="popup-new" id="form-new">
                <form class="form" id="form-apper" method="POST" action={{ url('admin/products/edit/' . $product->product_id) }} enctype="multipart/form-data">
                    @csrf

                    <div class="inner-form">

                        <div class="top-part">
                            
                            <div class="editable-name">
                                <span id="finalText" style="display: none;"></span>
                                <textarea id="name-input" placeholder="Nama Produk" name="name" rows="1" spellcheck="true">{{$product->product_name}}</textarea>
                            </div>

                            <div class="img-container">
                                
                                @if($product->product_img)
                                    <img src={{ asset('img/'. $product->product_img) }} alt="image-emp" id="img-view" class="image-item">
                                @endif
                                
                                <input type="file" accept="image/*" name="product_img" id="input-file" hidden>
                            </div>

                        </div>
                        

                        <div class="input-text">
                            
                            <div class="left-part">

                                <div class="inner-left">
                                    <div class="price-form">
                                        <label class="prc-label">Harga</label>
                                        <div class="inner-prc">
                                            <span class="prefix">Rp</span>
                                            <input type="text" id="prcInput" name="price" autocomplete="off" placeholder="0.00" value="{{$product->product_price}}">
                                        </div>
                                    
                                    </div>

                                    <div class="size-form">
                                        <label class="size-label">Size</label>
                                        <input type="text" id="sizeInput" style="display: block;" name="size" placeholder="" value="{{$product->product_size}}">
                                        
                                    </div>

                                    <div class="stock-form">
                                        <label class="stock-label">Stock</label>
                                        <input type="text" id="stockInput" style="display: block;" name="stock" placeholder="" value="{{$product->product_stock}}"> 
                                        
                                    </div>

                                    <div class="cat-form">
                                        <label class="cat-label">Category</label>
                                        <div class="select-box">
                                            <input type="text" class="input-cat" placeholder="" autocomplete="off" value="{{ $product->product_category }}">
                                            <input type="hidden" name="category" id="catId" value="{{ $product->product_category }}">
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

                                    <textarea id="deskripsiInput" name="description" style="display: block;">{{$product->product_description}}</textarea>
             
                            </div>
                            
                        </div>

                        
                    </div>
                    
                    <div class="btn-popup">
                        <button id="btn-cancel" type="button">Cancel</button>
                        <button id="btn-save" type="submit">Save</button>
                    </div>
                    

                </form>
            </div>

            <!--POP UP DELETE-->

            <div class="pop-dlt" id="popDlt">
                <form class="form-dlt" id="apperDlt" method="POST" action="{{ url("admin/products/delete/" . $product->product_id) }}">
                    @csrf
                    <div class="inner-dlt">
                        <div class="text-dlt">
                            <p>Apakah Kamu yakin ingin menghapus Produk ini?</p>
                        </div>
                    </div>

                    <div class="btn-dlt">
                        <button id="btn-cancel-dlt" type="button">Cancel</button>
                        <button id="btn-save-dlt" type="submit">Yes</button>
                    </div>
                </form>
            </div>
            
        </main>

    </div>

    <!--Script-->

    <!--ApexChart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/5.3.5/apexcharts.min.js" integrity="sha512-dC9VWzoPczd9ppMRE/FJohD2fB7ByZ0VVLVCMlOrM2LHqoFFuVGcWch1riUcwKJuhWx8OhPjhJsAHrp4CP4gtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--JS SOURCE-->
    <script src={{asset('admin/js/product.js')}}></script>

    <script>
        // LINE CHART

        var lineChartOptions = {
                series: [{
                    name: "Sales Order",
                    data: @json($chartTotals)
                }],
                chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
                },
                colors: [ "#5a321d", "#f6f0ed"
                ],
                dataLabels: {
                enabled: false
                },
                stroke: {
                curve: 'smooth'
                },
                title: {
                text: 'Sales Order by Month',
                align: 'left'
                },
                grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], 
                    opacity: 0.5
                },
                },
                xaxis: {
                categories: @json($chartMonths),
                }
                };

                var lineChart = new ApexCharts(document.querySelector("#line-chart"), lineChartOptions);
                lineChart.render();
    </script>
</body>
</html>