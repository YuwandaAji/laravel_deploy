<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Presence;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeesController extends Controller
{
    public function employees() {
        $employees = Employee::all();
        return view("employees", compact("employees"));
    }

    public function employee($employee_id) {
        $employee = Employee::with('schedules')->findOrFail($employee_id);

        $jadwalSiang = $employee->schedules
        ->where('shift', 0)
        ->pluck('schedule_day')
        ->implode(', ') ?: '-';

        $jadwalMalam = $employee->schedules
        ->where('shift', 1)
        ->pluck('schedule_day')
        ->implode(', ') ?: '-';

        $countPresent = $employee->presences()->where('status_presence', 'Present')->count();
        $countSick = $employee->presences()->where('status_presence', 'Sick')->count();
        $countPermission = $employee->presences()->where('status_presence', 'Permission')->count();
        $countAbsent = $employee->presences()->where('status_presence', 'Absent')->count();

        return view("employee", compact("employee", "jadwalSiang", "jadwalMalam", 'countPresent','countSick','countPermission','countAbsent'));
    }

    public function employees_add(Request $request) {
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:employee,employee_email',
        'employee_img' => 'image|mimes:jpeg,png,jpg|max:2048',
        'number_phone' => 'required|unique:employee,employee_number',
        'gender' => 'required|boolean',
        'address'=> 'required|string',
        'birth_date' => 'required|date|before:today',
        'role' => 'required|in:Manager,Barista,Waiter,Cashier,Courier',
        'salary' => 'required',
        'join_date' => 'required|date|before:today',
        'days'=> 'required|array',
        'shifts' => 'required|array'
    ]);

    $imageName = 'default_profile.png';
    if ($request->hasFile('employee_img')) {
        $imageName = $request->file('employee_img')->store('employee_img', 'public');
    }

    $employee = new Employee;
    $employee->employee_name = trim($request->name);
    $employee->employee_email = trim($request->email);
    $employee->password = bcrypt($request->password); 
    $employee->employee_number = $request->number_phone;
    $employee->employee_gender = $request->gender;
    $employee->employee_address = $request->address;
    $employee->employee_date_born = $request->birth_date;
    $employee->employee_role = $request->role;
    $employee->employee_img = $imageName;

    $employee->employee_salary = str_replace('.', '', $request->salary);
    
    $employee->employee_date_join = $request->join_date;

    $employee->save();

    if ($request->has('days')) {
        foreach ($request->days as $key => $dayValue) {
            $shiftValue = $request->shifts[$key];

            $schedule = Schedule::where('schedule_day', $dayValue)
                                ->where('shift', $shiftValue)
                                ->first();

            if ($schedule) {
                // Ini akan mengisi tabel pivot employee_schedule
                $employee->schedules()->attach($schedule->schedule_id);
            }
        }
    }


    return redirect('admin/employees')->with('success', 'Data Karyawan dan Jadwal Berhasil Disimpan!');
    }

    public function employees_search(Request $request) {
        $employees = Employee::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'employee_name',
                'employee_role'
            ], 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->role, function ($query) use ($request) {
            return $query->where('employee_role', $request->role);
        })->get();
        return view('employees', compact('employees'));
    }

    public function edit(Request $request, $employee_id) {

        $employee = Employee::findOrFail($employee_id);
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:employee,employee_email,' . $employee_id . ',employee_id',
        'employee_img' => 'image|mimes:jpeg,png,jpg|max:2048',
        'number_phone' => 'required|unique:employee,employee_number,' . $employee_id . ',employee_id',
        'gender' => 'required|boolean',
        'address'=> 'required|string',
        'birth_date' => 'required|date|before:today',
        'role' => 'required|in:Manager,Barista,Waiter,Cashier,Courier',
        'salary' => 'required',
        'join_date' => 'required|date|before:today',
        'days'=> 'required|array',
        'shifts' => 'required|array'
    ]);

    $imageName = $employee->employee_img; 

    if ($request->hasFile('employee_img')) {
        // Hapus foto lama jika ada (opsional agar storage tidak penuh)
        if ($employee->employee_img && $employee->employee_img != 'default_profile.png') {
            Storage::disk('public')->delete($employee->employee_img);
        }
        
        // Simpan foto baru
        $imageName = $request->file('employee_img')->store('employee_img', 'public');
    }
    $employee->employee_name = trim($request->name);
    $employee->employee_email = trim($request->email); 
    $employee->employee_number = $request->number_phone;
    $employee->employee_gender = $request->gender;
    $employee->employee_address = $request->address;
    $employee->employee_date_born = $request->birth_date;
    $employee->employee_role = $request->role;
    $employee->employee_img = $imageName;

    $employee->employee_salary = str_replace('.', '', $request->salary);
    
    $employee->employee_date_join = $request->join_date;
    if ($request->filled('password')) {
        $employee->password = bcrypt($request->password); 
    }

    $employee->save();

    if ($request->has('days')) {
    $scheduleIds = []; 

    foreach ($request->days as $key => $dayValue) {
        $shiftValue = $request->shifts[$key];

        $schedule = Schedule::where('schedule_day', $dayValue)
                            ->where('shift', $shiftValue)
                            ->first();

        if ($schedule) {
            $scheduleIds[] = $schedule->schedule_id;
        }
    }


    $employee->schedules()->sync($scheduleIds); 
}
    return redirect('admin/employees/'. $employee_id)->with('success', 'Data Karyawan dan Jadwal Berhasil Disimpan!');
    }

    public function addpresence(Request $request, $employee_id){
        
        $request->validate([
            'name_emp' => 'required',
            'status' => 'required|in:Present,Sick,Permission,Absent',
            'presence_date' => 'required|date',
        ]);

        Presence::create([
            'employee_id'     => $employee_id,
            'status_presence' => $request->status,
            'presence_date'   => $request->presence_date,
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect('admin/employees/'. $employee_id)->with('success', 'Presensi berhasil dicatat!');
    }

    public function delete($employee_id){
    $employee = Employee::findOrFail($employee_id);

    $employee->presences()->delete(); 

    $employee->schedules()->detach();

    if ($employee->employee_img && $employee->employee_img != 'default_profile.png') {
        Storage::disk('public')->delete($employee->employee_img);
    }

    $employee->delete();

    return redirect('admin/employees')->with('success', 'Karyawan dan seluruh data terkait berhasil dihapus!');
    }

    public function login() {
        $data['meta_title'] = 'Login';
        return view('loginemployees', $data);
    }

    public function login_post_employees(Request $request) {
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
            return redirect(url('employees/cashier'))->with('success','Login Succesfully');
        }else {
            
            dd('Login Gagal, data tidak cocok dengan database atau guard salah', $data);
        } 
    }

    public function logout() {
        Auth::guard('employees')->logout();
        return redirect(url('loginemployees'))->with('success','Logout Succesfully');
    }

    public function cashier() {
        return view('cashier');
    }
}

