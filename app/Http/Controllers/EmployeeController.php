<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use App\Models\Employee;
use App\Enums\EmployeeRole;
use App\Enums\EmployeeShift;
use App\Enums\EmployeeStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class EmployeeController extends Controller {
    public function update(Request $request, Employee $employee)
    {
        // 1. Lakukan Validasi data yang masuk
        $validatedData = $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_email' => 'required|email|unique:employees,employee_email,' . $employee->id,
            'employee_gender' => 'required|boolean', // 0 atau 1
            'employee_role' => 'required|integer',
            'employee_date_born' => 'nullable|date',
            'employee_salary' => 'required|integer',
            'employee_date_join' => 'required|date',
            'employee_img' => 'required|string',
            // ... validasi field lainnya
            'schedule' => 'nullable|array',
            'schedule.*.day_id' => 'required_with:schedule|integer',
            'schedule.*.shift_id' => 'required_with:schedule|integer',
        ]);
        
        // Menggunakan Database Transaction untuk memastikan data tersimpan semua
        try {
            DB::beginTransaction();

            $employee->update([
                'employee_name' => $validatedData['employee_name'],
                'employee_email' => $validatedData['employee_email'],
                'employee_gender' => $validatedData['employee_gender'],
                'employee_role' => $validatedData['employee_role'],
                'employee_date_born' => $validatedData['employee_date_born'],
                // ... field lainnya
            ]);


            if (isset($validatedData['schedule'])) {

                $employee->schedules()->delete();
                

                $employee->schedules()->createMany($validatedData['schedule']);
            }

            DB::commit();


            return response()->json([
                'success' => true, 
                'message' => 'Data Karyawan berhasil diperbarui.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false, 
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function delete(Employee $employee)
    {
        try {
            $employee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil dihapus.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus karyawan.'
            ], 500);
        }
    }
}

