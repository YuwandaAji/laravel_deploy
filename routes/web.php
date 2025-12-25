<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalesController;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;


Route::get('/', [AuthController::class, 'front']);
//Customer
Route::get( 'registration', [AuthController::class, 'registration']);
Route::post('register_post', [AuthController::class,'register_post']);

Route::get( 'login', [AuthController::class, 'login']);
Route::post('login_post', [AuthController::class,'login_post']);
Route::get('home', [AuthController::class,'home']);
Route::get('home', [AuthController::class,'products']);
Route::get('order', [AuthController::class,'order']);
Route::get('profile', [AuthController::class,'profile'])->middleware('auth');
Route::post('order_post', [AuthController::class,'order_post']);
Route::get('profile/edit', [AuthController::class,'edit']);
Route::get(url('logout'), [AuthController::class,'logout']);
Route::put('profile/edit/update', [AuthController::class,'update']);



//Employee
Route::middleware('employees')->prefix('employees')->group(function () {
    Route::get('cashier', [EmployeesController::class,'cashier']);
    Route::get('employees', [EmployeesController::class,'employees']);
});

Route::prefix('employees')->group(function () {
    Route::get('login', [EmployeesController::class,'login']);
    Route::post('login_post_employees', [EmployeesController::class,'login_post_employees']);
    Route::get(url('logout'), [EmployeesController::class,'logout']);
    Route::get('cashier', [CashierController::class,'cashier']);
    Route::get('cashier', [CashierController::class,'sales']);
    Route::get('cashier_search', [CashierController::class,'cashier_search']);
    Route::get('cashier/{sales_id}', [CashierController::class,'detail']);
    Route::post('sales/update-status/{sales_id}', [CashierController::class, 'update_status']);
});


//Admin
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class,'dashboard']);
    Route::get('employees', [AdminController::class,'employees']);
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class,'login']);
    Route::post('login_post_admin', [AdminController::class,'login_post_admin']);
    Route::get(url('logout'), [AdminController::class,'logout']);
    Route::get('dashboard', [DashboardController::class, 'dashboard']);
    Route::get('employees', [EmployeesController::class,'employees']);
    Route::get('employees/{employee_id}', [EmployeesController::class,'employee']);
    Route::post('employees_add', [EmployeesController::class,'employees_add']);
    Route::get('employees_search', [EmployeesController::class,'employees_search']);
    Route::post('employees/edit/{employee_id}', [EmployeesController::class,'edit']);
    Route::post('employees/addpresence/{employee_id}', [EmployeesController::class,'addpresence']);
    Route::post('employees/delete/{employee_id}', [EmployeesController::class,'delete']);
    Route::get('products', [ProductController::class,'products']);
    Route::post('products_add', [ProductController::class,'products_add']);
    Route::get('products_search', [ProductController::class,'products_search']);
    Route::get('products/{product_id}', [ProductController::class,'product']);
    Route::post('products/edit/{product_id}', [ProductController::class,'edit']);
    Route::post('products/delete/{product_id}', [ProductController::class,'delete']);
    Route::get('customers', [CustomerController::class,'customers']);
    Route::get('customers_search', [CustomerController::class,'customers_search']);
    Route::get('customers/{customer_id}', [CustomerController::class,'customer']);
    Route::get('payments', [PaymentController::class,'payments']);
    Route::get('payments_search', [PaymentController::class,'payments_search']);
    Route::get('payments/{payment_id}', [PaymentController::class,'payment']);
    Route::post('payment/active/{payment_id}', [PaymentController::class,'active']);
    Route::post('payment/nonactive/{payment_id}', [PaymentController::class,'nonactive']);
    Route::get('sales', [SalesController::class,'sales']);
    Route::get('sales_search', [SalesController::class,'sales_search']);
    Route::get('sales/{sales_id}', [SalesController::class,'sale']);
    Route::get('feedbacks', [FeedbackController::class,'feedbacks']);
    Route::get('feedbacks_search', [FeedbackController::class,'feedbacks_search']);
});


//Dasboard


Route::get('/link-storage', function () {
    // Menghapus link lama jika ada (opsional tapi bagus untuk jaga-jaga)
    if (is_link(public_path('storage'))) {
        app('files')->delete(public_path('storage'));
    }
    
    Artisan::call('storage:link');
    return "Storage link berhasil dibuat!";
});

Route::get('/buat-admin-darurat', function () {
    $check = Employee::where('employee_email', 'yuwanda@gmail.com')->first();
    
    if ($check) {
        return "User sudah ada! Silakan login.";
    }

    Employee::create([
        'employee_name' => 'Yuwanda Aji',
        'employee_address' => 'Jl. Sudirman No. 123',
        'employee_number' => '08123456789',
        'employee_gender' => 1,
        'employee_email' => 'yuwanda@gmail.com',
        'password' => Hash::make('ajiganteng'), 
        'employee_date_born' => '2006-03-12',
        'employee_role' => 'Manager',
        'employee_salary' => 5000000,
        'employee_date_join' => '2023-01-10',
        'employee_img' => 'employee_img/yuwandaaji.jpg'
    ]);

    return "User berhasil dibuat dengan password ter-bcrypt!";
});
