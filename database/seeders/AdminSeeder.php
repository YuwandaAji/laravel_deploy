<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('employee')->updateOrInsert(
            ['employee_id' => 1],
            [
                'employee_name'      => 'Yuwanda Aji',
                'employee_address'   => 'Surabaya',
                'employee_number'    => '083937746646',
                'employee_gender'    => 1,
                'employee_email'     => 'yuwanda@gmail.com',
                'password'           => Hash::make('ajiganteng'),
                'employee_date_born' => '2006-03-12',
                'employee_role'      => 'Manager',
                'employee_salary'    => 10000000,
                'employee_date_join' => '2026-03-07',
                'employee_img'       => '#',
            ]
        );
    }
}