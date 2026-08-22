<?php

namespace App\Enums;

enum RoleName: string
{
    case Admin = 'Admin';
    case Vendor = 'Vendor';
    case Customer = 'Customer';

    /**
     * Get all role values.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
