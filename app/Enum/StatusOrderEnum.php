<?php

namespace App\Enum;

enum StatusOrderEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case PAID = 'paid';
    case READY = 'ready';
    case FAILED = 'failed';

}
