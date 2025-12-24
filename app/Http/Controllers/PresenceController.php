<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id', // Pastikan ID karyawan ada
            'status_id' => 'required|integer', // Status (1=Present, 2=Absent, dst)
            'date' => 'required|date_format:Y-m-d',
        ]);


        $existing = Presence::where('employee_id', $validatedData['employee_id'])
                            ->where('date', $validatedData['date'])
                            ->exists();
        
        if ($existing) {
             return response()->json([
                'success' => false, 
                'message' => 'Presensi untuk tanggal ini sudah ada.'
            ], 409);
        }

        Presence::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat.'
        ], 201);
    }
}
