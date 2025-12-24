<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nonchalant Coffe Admin Dashboard</title>
    
    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link rel="stylesheet" href={{ asset("admin/css/dashboard.css") }}>
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
            <div class="main-title">
                <p class="font-weight-bold">DASHBOARD NONCHALANT COFFE</p>
            </div>

            <div class="main-card">

                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary">SALES ORDER</p>
                        <span class="material-symbols-outlined">list_alt</span>
                    </div>
                    <span class="text-primary font-weight-bold">{{ $totalsales }}</span>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary">REVENUE</p>
                        <span class="material-symbols-outlined">attach_money</span>
                    </div>
                    <span class="text-primary font-weight-bold">{{ $totalrevenue }}</span>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary">FEEDBACK</p>
                        <span class="material-symbols-outlined">feedback</span>
                    </div>
                    <span class="text-primary font-weight-bold">{{ $totalfeedback }}</span>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary">TOTAL CUSTOMER</p>
                        <span class="material-symbols-outlined">groups</span>
                    </div>
                    <span class="text-primary font-weight-bold">{{ $totalcustomer }}</span>
                </div>
            </div>

            <div class="charts">

                <div class="chart-card">
                    <p class="chart-title">Top 5 Produk In This Month</p>
                    <div id="bar-chart"></div>
                </div>

                <div class="chart-card">
                    <p class="chart-title">Sales Per Month</p>
                    <div id="line-chart"></div>
                </div>

            </div>
        </main>
        <!--END MAIN-->
    </div>

    <!--Script-->

    <!--ApexChart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/5.3.5/apexcharts.min.js" integrity="sha512-dC9VWzoPczd9ppMRE/FJohD2fB7ByZ0VVLVCMlOrM2LHqoFFuVGcWch1riUcwKJuhWx8OhPjhJsAHrp4CP4gtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--Source JS-->


    <script>
        // BAR CHART

        var barChartOptions = {
            series: [{
            data: @JSON($totalProduct)
            }],
            chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            }
            },
            colors: [
                "#5a321d",
                "#5a321d",
                "#5a321d",
                "#5a321d",
                "#5a321d"
            ],
            plotOptions: {
            bar: {
                borderRadius: 4,
                borderRadiusApplication: 'end',
                horizontal: false,
                columnWidht: "40%",
            }
            },
            dataLabels: {
            enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
            categories: @json($nameProducts)
            ,
            },
            yaxis: {
                title: {
                    text : "Count" 
                }
            }
            };

            var barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
            barChart.render();

            // SIDEBAR TOOGLE

            var sidebarOpen = false;
            var sidebar = document.getElementById("sidebar");

            function openSidebar() {
                if (!sidebarOpen) {
                    sidebar.classList.add("sidebar-responsive");
                    sidebarOpen = true;
                }
            }

            function closeSidebar() {
                if (sidebarOpen) {
                    sidebar.classList.remove("sidebar-responsive");
                    sidebarOpen = false;
                }
            }

            //  LOGOUT TOOGLE

            function subMenu() {
                const submenu = document.getElementById("submenu");
                submenu.classList.toggle("open-menu");
            }

            // SIDEBAR ITEM ACTIVE

            var currentPage = window.location.pathname;
            console.log("Current page:", currentPage);

            document.querySelectorAll(".sidebar-list-item a").forEach(link => {
                    if (currentPage.endsWith(link.getAttribute("href"))) {
                        link.parentElement.classList.add("active");
                    }
                })



    </script>

    <script>
        // LINE CHART

        var lineChartOptions = {
                series: [{
                    name: "Sales Order",
                    data: @json($totalLineChart)
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
                categories: @json($labelsales)
                }
            };

            var lineChart = new ApexCharts(document.querySelector("#line-chart"), lineChartOptions);
            lineChart.render();
    </script>
</body>
</html>