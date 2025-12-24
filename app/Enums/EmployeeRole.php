<?php

namespace App\Enums;

enum EmployeeRole: int
{
    case Manager = 1;
    case Barista = 2;
    case Waiter = 3;
    case Courier = 4;
    case Chasier = 5;

    public function label(): string
    {
        return match ($this) {
            self::Manager => 'Manager',
            self::Barista => 'Barista',
            self::Waiter => 'Waiter',
            self::Courier => 'Courier',
            self::Chasier => 'Chasier',
        };
    }
}