<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $employee->employee_name }}</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{ asset('admin/css/employee.css') }} rel="stylesheet">
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

                <div class="emp-name">
                    <p class="font-weight-bold">{{ $employee->employee_name }}</p>
                </div>

                <div class="feature-right">
                    <button id="btnPsc">Presensi</button>
                    <button id="btnEdit">Edit</button>
                    <button id="btnDelete">Delete</button>
                </div>
            </div>

            <div class="main-info-emp">
                <div class="img-emp">
                    @if($employee->employee_img)
                        <img src={{ asset('storage/'. $employee->employee_img) }} alt="image-emp" class="image-emp">
                    @endif
                </div>

                <div class="info-mid">
                    <div class="info-work">
                        <p class="info-title">Informasi Pekerjaan</p>
                        <div class="info-inti">
                            <p>Role: <span>{{ $employee->employee_role }}</span></p>
                            <p>Salary: <span>Rp {{ $employee->employee_salary }}</span></p>
                        </div>
                        
                    </div>

                    <div class="info-emp">
                        <p class="info-title">Data Karyawan</p>
                        <div class="info-inti">
                            <p>Nama: <span>{{ $employee->employee_name }}</span></p>
                            <p>EmpID: <span>{{ $employee->employee_id }}</span></p>
                            <p>Gender: <span>{{ $employee->gender_text }}</span></p>
                            <p>Email: <span>{{ $employee->employee_email }}</span></p>
                            <p>No.Hp: <span>{{ $employee->employee_number }}</span></p>
                            <p>Alamat: <span>{{ $employee->employee_address }}</span></p>
                            <p>Tgl Lhr: <span>{{ $employee->employee_date_born }}</span></p>
                        </div>
                    </div>
                    
                </div>

                <div class="info-right">

                    <div class="shift-emp">
                        <p class="info-title">Jadwal Shift</p>
                        <div class="info-inti">
                            <p>Morning: <span>{{ $jadwalSiang }}</span></p>
                            <p>Evening: <span>{{ $jadwalMalam }}</span></p>
                        </div>
                        
                    </div>

                    <div class="chart">
                        <p class="chart-title">Performa Kehadiran</p>
                        <div id="pie-chart"></div>
                    </div>
                </div>
            </div>

            <!--Pop Up Edit-->

            <div class="popup-new" id="form-new">
                <form class="form" id="form-apper" method="post" action={{ url('admin/employees/edit/' . $employee->employee_id) }} enctype="multipart/form-data">
                    @csrf

                    <div class="inner-form">

                        <div class="top-part">

                            <div class="img-container">
                                
                                @if($employee->employee_img)
                                    <img src={{ asset('storage/'. $employee->employee_img) }} alt="image-emp" id="img-view">
                                @endif
                                
                                <input type="file" accept="image/*" name="employee_img" id="input-file" hidden>
                            </div>
                            
                            <div class="text-top">
                                <div class="editable-name">
                                    <span id="finalText" style="display: none;"></span>
                                    <textarea name="name" id="name-input" placeholder="Nama Karyawan" rows="1" spellcheck="true">{{ $employee->employee_name }}</textarea>
                                </div>

                                <div class="email_password">
                                    <div class="email-form">
                                        <span class="material-symbols-outlined">mail</span>
                                        <input type="text" name="email" id="emailInput" style="display: block;" placeholder="email" value={{ $employee->employee_email  }}>
                                                
                                    </div> 

                                    <div class="password-form">
                                        <span class="material-symbols-outlined">password</span>
                                        <input type="password" name="password" id="passwordInput" style="display: block;" placeholder="password">
                                                
                                    </div> 
                                </div>   
                                
                                <div class="phone-form">
                                    <span class="material-symbols-outlined">phone_in_talk</span>
                                    <input type="text" id="phoneInput" name="number_phone" style="display: block;" placeholder="Work Phone" value={{ $employee->employee_number  }}>
                                            
                                </div>
                            </div>
                            

                        </div>
                        

                        <div class="input-text">
                            
                            <div class="left-part">

                                <div class="inner-left">

                                    <div class="left_title">PERSONAL INFORMATION</div>

                                    <div class="gender-form">
                                        <label class="gdr-label">Gender</label>
                                        <div class="gender-value">
                                            <input type="radio" name="gender" value="1" id="genderInput" @checked($employee->employee_gender == 1)>Male
                                            <input type="radio" name="gender" value="0" id="genderInput" @checked($employee->employee_gender == 0)>Female
                                        </div>
                                        
                                    </div>

                                    <div class="address-form">
                                        <label class="address-label">Address</label>
                                        <input type="text" id="addressInput" name="address" style="display: block;" placeholder="" value="{{ $employee->employee_address }}">
                                        
                                    </div>

                                    <div class="birth-date-form">
                                        <label class="birth-label">Birth Date</label>
                                        <input type="date" id="birthInput" name="birth_date" style="display: block;" placeholder="" value={{ $employee->employee_date_born  }} >
                                        
                                    </div>

                                    
                                </div>
                                
                            </div>

                            <div class="right-part">

                                <div class="inner-right">
                                    <div class="left_title">WORK INFORMATION</div>

                                    <div class="role-form">
                                        <label class="role-label">Role</label>
                                        <div class="select-box">
                                            <input type="text" class="input-role" placeholder="" autocomplete="off" value="{{ $employee->employee_role  }}">
                                            <input type="hidden" name="role" id="roleId" value="{{ $employee->employee_role }}">
                                            <ul class="select-options">
                                                <li data-value="Manager">Manager</li>
                                                <li data-value="Barista">Barista</li>
                                                <li data-value="Waiter">Waiter</li>
                                                <li data-value="Cashier">Cashier</li>
                                                <li data-value="Courier">Courier</li>
                                            </ul>
                                        </div>
                                        
                                    </div>

                                    <div class="salary-form">
                                        <label class="salary-label">Salary</label>
                                        <div class="inner-slr">
                                            <span class="prefix">Rp</span>
                                            <input type="text" name="salary" id="salaryInput" autocomplete="off" placeholder="0.00" value={{ $employee->employee_salary  }}>
                                        </div>
                                            
                                    </div>

                                    <div class="join-date-form">
                                        <label class="join-label">Join Date</label>
                                        <input type="date" name="join_date" id="joinInput" style="display: block;" placeholder="" value={{ $employee->employee_date_join  }}>
                                            
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                        </div>

                        <div class="bottom-part">
                            <table class="table-shift">
                                <thead >
                                    <tr class="header-table">
                                        <th class="day">
                                            <span>Day</span>
                                        </th>

                                        <th class="shift">
                                            <span>Shift</span>
                                        </th>

                                        <th class="delete">
                                            <span class="material-symbols-outlined">settings_input_component</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-body">
                                    @foreach($employee->schedules as $schedule)
                                    <tr class="row-item">
                                        <td>
                                            <div class="select-box">
                                                <input type="text" class="input-day" value="{{ $schedule->schedule_day }}" readonly>
                                                <input type="hidden" name="days[]" value="{{ $schedule->schedule_day }}">
                                                <ul class="select-options">
                                                    <li data-value="Monday">Monday</li>
                                                    <li data-value="Tuesday">Tuesday</li>
                                                    <li data-value="Wednesday">Wednesday</li>
                                                    <li data-value="Thursday">Thursday</li>
                                                    <li data-value="Friday">Friday</li>
                                                    <li data-value="Saturday">Saturday</li>
                                                    <li data-value="Sunday">Sunday</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="select-box">
                                                <input type="text" class="input-shift" value="{{ $schedule->shift == 0 ? 'Siang' : 'Malam' }}" readonly>
                                                <input type="hidden" name="shifts[]" value="{{ $schedule->shift }}">
                                                <ul class="select-options">
                                                    <li data-value="0">Morning</li>
                                                    <li data-value="1">Evening</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td style="text-align: end;">
                                            <span class="material-symbols-outlined delete-btn" onclick="this.closest('tr').remove()">delete</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <div class="odoo-add-line" onclick="addScheduleRow()">
                                                <i class="fa fa-plus-circle"></i> Add a line
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="btn-popup">
                            <button id="btn-cancel" type="button">Cancel</button>
                            <button id="btn-save" type="submit">Save</button>
                        </div>

                    </div>
                    
                </form>
            </div>

            <!--POP UP PRESENSI-->
            <div class="popup-psc" id="popupPsc">
                <form class="form-psc" id="apperPsc" method="post" action={{ url('admin/employees/addpresence/' . $employee->employee_id) }}>
                    @csrf
                    <div class="inner-psc">
                
                        <div class="text-psc">
                            

                            <div class="nama-psc">
                                <label class="psc-label">Nama</label>
                                <input type="text" id="namePscInput" name="name_emp" style="display: block;" placeholder="" value="{{ $employee->employee_name }}">
                            </div>

                            <div class="status-psc">
                                <label class="status-psc-label">Status</label>
                                <div class="select-box">
                                    <input type="text" class="input-status" placeholder="" autocomplete="off" >
                                    <input type="hidden" name="status" id="statusId" class="Inputstatus" >
                                    <ul class="select-options">
                                        <li data-value="Present">Present</li>
                                        <li data-value="Sick">Sick</li>
                                        <li data-value="Permission">Permission</li>
                                        <li data-value="Absent">Absent</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="date-psc">
                                <label class="date-psc-label">Tanggal</label>
                                <input type="date" id="datePscInput" name="presence_date" style="display: block;" placeholder="">
                            </div>

                            
                        </div>
                        
                        <div class="btn-psc">
                            <button id="btn-cancel-psc" type="button">Cancel</button>
                            <button id="btn-save-psc" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--POP UP DELETE-->

            <div class="pop-dlt" id="popDlt">
                <form class="form-dlt" id="apperDlt" method="post" action={{ url("admin/employees/delete/" . $employee->employee_id) }}>
                    @csrf
                    <div class="inner-dlt">
                        <div class="text-dlt">
                            <p>Apakah Kamu yakin ingin menghapus Karyawan  ini?</p>
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
    <script src={{ asset('admin/js/employee.js') }}></script>

    <script>
        // PIE CHART

    var pieChartOptions = {
            series: [@json($countPresent), @json($countSick), @json($countPermission), @json($countAbsent)],
            labels: ['Present', 'Sick', 'Permission', 'Absent'],
            colors: ['#5a321d', '#3f2111ff', '#2d1e16ff', '#151211ff'],
            chart: {
            type: 'donut',
            toolbar: {
                show: false
            }
            },
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 200
                },
                legend: {
                position: 'bottom'
                }
            }
            }]
            };

            var pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieChartOptions);
            pieChart.render();
    </script>
</body>
</html>