<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Customers extends Model
{
    /** @use HasFactory<\Database\Factories\CustomersFactory> */
    use HasFactory, HasRoles, SoftDeletes;

    protected $fillable = ['name', 'email', 'no_phone', 'birth_date', 'gender', 'point'];

    public function order(): HasMany
    {
        return $this->hasMany(Orders::class);
    }
}
