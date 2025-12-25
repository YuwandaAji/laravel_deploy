<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $payment->payment_name }}</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{asset('admin/css/payment.css')}} rel="stylesheet">
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

                <div class="pay-name">
                    <p class="font-weight-bold">{{ $payment->payment_name }}</p>
                </div>

                <div class="feature-right">
                    <button id="btnAktif" class="{{ $payment->payment_status == 1 ? 'active' : '' }}">Aktif</button>
                    <button id="btnNonAktif" class="{{ $payment->payment_status == 0 ? 'active' : '' }}">Non Aktif</button>
                </div>
            </div>

            <div class="main-info-item">
                
                @if($payment->payment_img)
                    <img src={{ asset('img/'. $payment->payment_img) }} alt="image-emp" class="image-pay">
                @endif

                <div class="info-right">

                    <div class="data-pay">
                        <p class="data-title">Rincian Produk</p>
                        <div class="info-inti">
                            <p>Nama: <span>{{ $payment->payment_name }}</span></p>
                            <p>Kategori: <span>{{ $payment->payment_category }}</span></p>
                        </div>
                    </div>

                    <div class="info-status">
                        <p class="status-title">Status</p>
                        <p class="status-text">{{ $payment->payment_status == 1 ? 'Aktif' : 'Tidak Aktif' }}</p>
                    </div>       
                    
                    <div class="info-pay-container">
                        <div class="info-pay">
                            <p class="pay-title">Used Today</p>
                            <p class="pay-text">{{$usedToday}}</p>
                        </div>

                        <div class="info-pay">
                            <p class="pay-title">Revenue</p>
                            <p class="pay-text">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                        </div>

                    </div>
                </div>

                <div class="chart">
                    <p class="chart-title">Used By Month</p>
                     <div id="line-chart"></div>
                </div>
            </div>

            <!--POP UP AKTIF-->

            <div class="pop-akf" id="popAkf">
                <form class="form-akf" id="apperAkf" method="POST" action="{{ url("admin/payment/active/" . $payment->payment_id) }}">
                    @csrf
                    <div class="inner-akf">
                        <div class="text-akf">
                            <p>Apakah Kamu ingin mengaktifkan metode pembayaran ini?</p>
                        </div>
                    </div>

                    <div class="btn-akf">
                        <button id="btn-cancel-akf" type="button">Cancel</button>
                        <button id="btn-save-akf" type="submit">Yes</button>
                    </div>
                </form>
            </div>

            <!--POP UP NONAKTIF-->

            <div class="pop-nkf" id="popNkf">
                <form class="form-nkf" id="apperNkf" method="POST" action="{{ url("admin/payment/nonactive/" . $payment->payment_id) }}">
                    @csrf
                    <div class="inner-nkf">
                        <div class="text-nkf">
                            <p>Apakah Kamu yakin ingin menonaktifkan metode pembayaran ini?</p>
                        </div>
                    </div>

                    <div class="btn-nkf">
                        <button id="btn-cancel-nkf" type="button">Cancel</button>
                        <button id="btn-save-nkf" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </main>

    </div>

    <!--Script-->

    <!--ApexChart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/5.3.5/apexcharts.min.js" integrity="sha512-dC9VWzoPczd9ppMRE/FJohD2fB7ByZ0VVLVCMlOrM2LHqoFFuVGcWch1riUcwKJuhWx8OhPjhJsAHrp4CP4gtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--JS SOURCE-->
    <script src={{ asset('admin/js/payment.js') }}></script>

    <script>
        // LINE CHART

        var lineChartOptions = {
                series: [{
                    name: "Used by Month",
                    data: @json($chartData)
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
                text: 'Used by Month',
                align: 'left'
                },
                grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], 
                    opacity: 0.5
                },
                },
                xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                }
                };

                var lineChart = new ApexCharts(document.querySelector("#line-chart"), lineChartOptions);
                lineChart.render();
    </script>
</body>
</html>