<?php

namespace App\Enums;

enum EmployeeStatus: int
{
    case Present = 1;
    case Absent = 2;
    case Sick = 3;
    case Permission = 4;
    
    // Method untuk mendapatkan label yang mudah dibaca
    public function label(): string
    {
        return match ($this) {
            self::Present => 'Present',
            self::Absent => 'Absent',
            self::Sick => 'Sick',
            self::Permission => 'Permission',
        };
    }
}
