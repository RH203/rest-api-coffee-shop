<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vouchers extends Model
{
    /** @use HasFactory<\Database\Factories\VouchersFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['voucher_name', 'voucher_code', 'used_count', 'max_count', 'is_active', 'start_date', 'end_date'];
}
