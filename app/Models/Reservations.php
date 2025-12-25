<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservations extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['reservation_no', 'reservation_date', 'reservation_time', 'customer_name', 'customer_phone', 'total_visit'];
}
