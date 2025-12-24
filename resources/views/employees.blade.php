<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nonchalant Coffe Admin Employee</title>

    <!--FONT Source-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--ICON Source-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

    <!--Source CSS-->
    <link href={{asset("admin/css/employees.css")}} rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
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
                <p class="font-weight-bold">KARYAWAN NONCHALANT COFFE</p>
            </div>

            <div class="main-feature">

                <div class="feature-left">
                    <button id="button-new" class="add-btn">+ Add</button>
                </div>

                <div class="feature-right">
                    <form class="search" method="get" action={{ url("admin/employees_search") }}>
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
                            <li class="filter-item"><a href="{{ url('admin/employees_search?role=Manager') }}"><span>Manager</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/employees_search?role=Barista') }}"><span>Barista</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/employees_search?role=Courier') }}"><span>Courier</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/employees_search?role=Cashier') }}"><span>Cashier</span></a></li>
                            <li class="filter-item"><a href="{{ url('admin/employees_search?role=Waiter') }}"><span>Waiter</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <div class="main-card" style="display: flex; flex-wrap: wrap; gap: 20px; width: 100%; padding: 20px 0;">
                @foreach ($employees as $employee)
                    <div class="card">
                        <a href={{ url("admin/employees/$employee->employee_id") }}  class="card-link">
                            @if($employee->employee_img)
                                <img src={{ asset('storage/'. $employee->employee_img) }} alt="image-emp">
                            @endif
                            <p class="name-emp">{{$employee->employee_name}}</p>
                            <p class="position-emp">{{$employee->employee_role}}</p>
                        </a>
                        
                    </div>
                    
                @endforeach

            </div>

            <!--Pop Up New-->

            <div class="popup-new" id="form-new">
                <form action={{ url("admin/employees_add") }} method="POST" enctype="multipart/form-data" id="form-apper" class="form">
                    @csrf
                    

                    <div class="inner-form">

                        <div class="top-part">

                            <div class="img-container">
                                
                                <img src={{ asset("admin/img/default-camera.jpg") }} id="img-view">
                                
                                <input type="file" accept="image/*" name="employee_img" id="input-file" hidden>
                            </div>
                            
                            <div class="text-top">
                                <div class="editable-name">
                                    <span id="finalText" style="display: none;"></span>
                                    <textarea id="name-input" name="name" placeholder="Nama Karyawan" rows="1" spellcheck="true"></textarea>
                                </div>

                                <div class="email_password">
                                    <div class="email-form">
                                        <span class="material-symbols-outlined">mail</span>
                                        <input type="text" name="email" id="emailInput" style="display: block;" placeholder="email">
                                                
                                    </div> 

                                    <div class="password-form">
                                        <span class="material-symbols-outlined">password</span>
                                        <input type="password" name="password" id="passwordInput" style="display: block;" placeholder="password">
                                                
                                    </div> 
                                </div>
                                    
                                
                                <div class="phone-form">
                                    <span class="material-symbols-outlined">phone_in_talk</span>
                                    <input type="text" name="number_phone" id="phoneInput" style="display: block;" placeholder="Work Phone">
                                            
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
                                            <input type="radio" name="gender" value="1" id="genderInput" >Male
                                            <input type="radio" name="gender" value="0" id="genderInput" >Female
                                        </div>
                                        
                                    </div>

                                    <div class="address-form">
                                        <label class="address-label">Address</label>
                                        <input type="text" name="address" id="addressInput" style="display: block;" placeholder="">
                                        
                                    </div>

                                    <div class="birth-date-form">
                                        <label class="birth-label">Birth Date</label>
                                        <input type="date" name="birth_date" id="birthInput" style="display: block;" placeholder="">
                                        
                                    </div>

                                    
                                </div>
                                
                            </div>

                            <div class="right-part">

                                <div class="inner-right">
                                    <div class="left_title">WORK INFORMATION</div>

                                    <div class="role-form">
                                        <label class="role-label">Role</label>
                                        <div class="select-box">
                                            <input type="text" class="input-role" placeholder="" autocomplete="off">
                                            <input type="hidden" name="role" id="roleId">
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
                                            <input type="text" id="salaryInput" name="salary" autocomplete="off" placeholder="0.00">
                                        </div>
                                            
                                    </div>

                                    <div class="join-date-form">
                                        <label class="join-label">Join Date</label>
                                        <input type="date" id="joinInput" name="join_date" style="display: block;" placeholder="">
                                            
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
                                    
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <div class="odoo-add-line" onclick="addRow()">
                                                <i class="fa fa-plus-circle"></i> Add a line
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="btn-popup">
                            <button id="btn-cancel">Cancel</button>
                            <button id="btn-save" type="submit">Save</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </main>

    </div>

    <!--JS SOURCE-->
    <script src={{ asset("admin/js/employees.js") }}></script>
   
    
</body>
</html>