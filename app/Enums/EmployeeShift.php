<?php

namespace App\Enums;

enum EmployeeShift: int
{
    case Afternoon = 1;
    case Night = 2;
    
    public function label(): string
    {
        return match ($this) {
            self::Afternoon => 'Afternoon',
            self::Night => 'Night',
        };
    }
}
