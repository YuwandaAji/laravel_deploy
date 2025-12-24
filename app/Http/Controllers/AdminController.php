<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login() {
        $data['meta_title'] = 'Login';
        return view('loginadmin', $data);
    }

    public function login_post_admin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:50',
        ]);

        $check = $request->all();
        $data = [
            'employee_email'=> $check['email'],
            'password'=> $check['password'],
        ];

        if(Auth::guard('employees')->attempt($data)) {
            $request->session()->regenerate();
            return redirect(url('admin/dashboard'))->with('success','Login Succesfully');
        }else {
            
            dd('Login Gagal, data tidak cocok dengan database atau guard salah', $data);
        } 
    
    }

    public function logout() {
        Auth::guard('employees')->logout();
        return redirect(url('loginadmin'))->with('success','Logout Succesfully');
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function employees() {
        return view('employees');
    }
    
}
