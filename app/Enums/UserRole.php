<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case PetOwner = 'pet_owner';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
