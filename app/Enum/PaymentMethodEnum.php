<?php

namespace App\Enum;

enum PaymentMethodEnum: string
{
    case QRIS = 'qris';
    case CASH = 'cash';
    case BANKTRANSFER = 'banktransfer';

}
