<?php

namespace App\Enum;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case KASIR = 'kasir';
    case CUSTOMER = 'customer';
}
